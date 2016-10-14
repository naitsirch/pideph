<?php

namespace Pideph\Document;

use Pideph\Document\Structure\Objects\Catalog;
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

        $version = $this->document->getCatalog()->getVersion();
        $this->result = "%PDF-$version\n";
        $this->result .= "%"."\xC6\xA5"."\xC8\x8B"."\xE1\xB8\x8B"."\xD0\xB5"."\xD1\x80"."\xD2\xBB"."\n\n";

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
        $containerObjects = $this->inlineContainerObjects();

        // collect indirect objects
        foreach ($containerObjects as $object) {
            $info = $containerObjects[$object];
            if ($info->referenceCounter > 1 || $object instanceof Catalog) {
                $info->index = $this->indirectObjectStorage->count() + 1;
                $this->indirectObjectStorage[$object] = $info;
            }
        }

        $result = &$this->result;


        //$this->collectIndirectObjects($this->document->getCatalog());
        foreach ($this->indirectObjectStorage as $object) {
            $info = $this->indirectObjectStorage[$object];
            $info->offset = strlen($result);

            $serialized = $this->serializeObject($object);

            $result .= $info->index . " 0 obj " . $serialized . " endobj\n";
        }

        $result .= "\n";
    }

    private function serializeObject($object)
    {
        if ($object instanceof Dictionary) {
            $serializedValues = array();
            foreach ($object as $key => $childValue) {
                if ($childValue !== null) {
                    if (is_object($childValue) && $this->indirectObjectStorage->contains($childValue)) {
                        $serializedValues[] = "/$key " . $this->indirectObjectStorage[$childValue]->index . ' 0 R';
                    } else {
                        $serializedValues[] = "/$key " . $this->serializeObject($childValue);
                    }
                }
            }
            return '<< ' . implode(' ', $serializedValues) . ' >>';
        } else if ($object instanceof \ArrayObject) {
            $length = $object->count();
            $serializedValues = array();
            for ($i = 0; $i < $length; $i++) {
                $serializedValues[] = $this->serializeObject($object[$i]);
            }
            return '[' . implode(' ', $serializedValues) . ']';
        } else if ($object instanceof Name) {
            return '/' . $object->getName();
        } else if (is_string($object)) {
            if (substr_count($object, '(') != substr_count($object, ')')) {
                $msg = 'Unbalanced number of parentheses is not allowed in a literal string "%s".';
                throw new \Exception(sprintf($msg, $object));
            }
            return "($object)";
        } else if (is_int($object) || is_float($object)) {
            return $object;
        }

        throw new \Exception(sprintf('Value of type "%s" is not serializable.', gettype($object)));
    }

    /**
     * Collects all objects of the document graph.
     *
     * @param object $node
     * @param \SplObjectStorage $objects
     * @return \SplObjectStorage
     */
    private function inlineContainerObjects($node = null, \SplObjectStorage $objects = null)
    {
        if (null === $objects || $objects->count() == 0) {
            $node = $this->document->getCatalog();
            $objects = new \SplObjectStorage();
        } else if (!$node instanceof Dictionary && !$node instanceof \ArrayObject) {
            return $objects;
        }

        if ($objects->contains($node)) {
            $objects[$node]->referenceCounter++;
            return $objects;
        } else {
            $objects[$node] = new \stdClass();
            $objects[$node]->referenceCounter = 1;
        }

        foreach ($node as $item) {
            $this->inlineContainerObjects($item, $objects);
        }
        return $objects;
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
            $result .= str_pad($info->offset, 10, '0', STR_PAD_LEFT) . " 00000 n \n";
        }
    }

    private function writeTrailer()
    {
        $result = &$this->result;

        $size = $this->indirectObjectStorage->count() + 1;
        $rootInfo = $this->indirectObjectStorage[$this->document->getCatalog()];
        $rootRef = $rootInfo->index . ' 0 R';

        $result .= "trailer\n";
        $result .= "<< /Size $size /Root $rootRef >>\n";

        $result .= "startxref\n";
        $result .= $this->lastXrefSectionOffset . "\n";
    }
}
