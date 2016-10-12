<?php

namespace Pideph\Document;

use Pideph\Document\Structure\Objects\Dictionary;
use Pideph\Document\Structure\Objects\Name;

/**
 * Pideph\Document\StringGenerator
 *
 * @author naitsirch
 */
class StringGenerator
{
    private $document;
    private $result;

    /**
     * Stores all container objects
     * @var \SplObjectStorage
     */
    private $indirectObjectStorage;

    /**
     * Byte offset of the "xref" keyword of the last cross reference section.
     * @var int
     */
    private $lastXrefSectionOffset;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function generate()
    {
        $this->indirectObjectStorage = new \SplObjectStorage();

        $this->result = "%PDF-1.4 %"."\xC6\xA5"."\xC8\x8B"."\xE1\xB8\x8B"."\xD0\xB5"."\xD1\x80"."\xD2\xBB"."\n\n";

        $this->writeIndirectObjects();
        $this->writeCrossReferenceTable();
        $this->writeTrailer();

        $this->result .= "%%EOF";
    }

    public function getResult()
    {
        return $this->result;
    }

    private function writeIndirectObjects()
    {
        $this->collectIndirectObjects($this->document->getCatalog());

        $result = &$this->result;

        foreach ($this->indirectObjectStorage as $object) {
            $info = $this->indirectObjectStorage[$object];
            $info['offset'] = strlen($result);
            $this->indirectObjectStorage[$object] = $info;

            $result .= $info['index'] . " 0 obj " . $info['serialized'] . " endobj\n";
        }

        $result .= "\n";
    }

    private function collectIndirectObjects($value)
    {
        if ($value instanceof Dictionary) {
            if ($this->indirectObjectStorage->contains($value)) {
                $storeInfo = $this->indirectObjectStorage->offsetGet($value);
                return $storeInfo['index'] . ' 0 R';
            }
            $index = $this->indirectObjectStorage->count() + 1;

            $storeInfo = array(
                'index' => $index,
                'serialized' => null,
            );
            $this->indirectObjectStorage->attach($value, $storeInfo);

            $serializedValues = array();
            foreach ($value as $key => $childValue) {
                if ($childValue !== null) {
                    $serializedValues[] = "/$key " . $this->collectIndirectObjects($childValue);
                }
            }

            $storeInfo['serialized'] = '<< ' . implode(' ', $serializedValues) . ' >>';

            $this->indirectObjectStorage->attach($value, $storeInfo);

            return $storeInfo['index'] . ' 0 R';
        } else if ($value instanceof Name) {
            return '/' . $value->getName();
        } else if (is_array($value)) {
            $length = count($value);
            $serializedValues = array();
            for ($i = 0; $i < $length; $i++) {
                if (!isset($value[$i])) {
                    $msg = 'Only purely indexed arrays are allowed. But we got an array with these keys: "%s". Use a Dictionary instead.';
                    throw new \Exception(sprintf($msg, implode(', ', array_keys($value))));
                }
                $serializedValues[] = $this->collectIndirectObjects($value[$i]);
            }
            return '[' . implode(' ', $serializedValues) . ']';
        } else if (is_string($value)) {
            if (substr_count($value, '(') != substr_count($value, ')')) {
                $msg = 'Unbalanced number of parentheses is not allowed in a literal string "%s".';
                throw new \Exception(sprintf($msg, $value));
            }
            return "($value)";
        } else if (is_int($value) || is_float($value)) {
            return $value;
        }

        throw new \Exception(sprintf('Value of type "%s" is not serializable.', gettype($value)));
    }

    private function writeCrossReferenceTable()
    {
        $result = &$this->result;

        $this->lastXrefSectionOffset = strlen($result);

        $result .= "xref\n";
        $result .= '0 ' . ($this->indirectObjectStorage->count() + 1) . "\n";
        $result .= "0000000000 65535 f \n";

        foreach ($this->indirectObjectStorage as $dictionary) {
            $info = $this->indirectObjectStorage[$dictionary];
            $result .= str_pad($info['offset'], 10, '0', STR_PAD_LEFT) . " 00000 n \n";
        }
    }

    private function writeTrailer()
    {
        $result = &$this->result;

        $size = $this->indirectObjectStorage->count() + 1;
        $rootInfo = $this->indirectObjectStorage[$this->document->getCatalog()];
        $rootRef = $rootInfo['index'] . ' 0 R';

        $result .= "trailer\n";
        $result .= "<< /Size $size /Root $rootRef >>\n";

        $result .= "startxref\n";
        $result .= $this->lastXrefSectionOffset . "\n";
    }
}
