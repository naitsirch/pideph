<?php

namespace Pideph\Document;

use Pideph\Document\Structure\Objects\Dictionary;
use Pideph\Document\Structure\Objects\Name;
use Pideph\Document\Structure\Objects\OnlyIndirectlyReferencable;
use Pideph\Document\Structure\Objects\Stream;

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

            if ($info->referenceCounter > 1
                || ($object instanceof OnlyIndirectlyReferencable && $object->isOnlyIndirectlyReferencable())
            ) {
                $info->index = $this->indirectObjectStorage->count() + 1;
                $this->indirectObjectStorage[$object] = $info;
            }
        }

        $result = &$this->result;


        //$this->collectIndirectObjects($this->document->getCatalog());
        foreach ($this->indirectObjectStorage as $object) {
            $info = $this->indirectObjectStorage[$object];
            $info->offset = strlen($result);

            $serialized = $this->serializeValue($object, false);

            if (substr($serialized, -1) !== "\n") {
                $serialized .= "\n";
            }
            $result .= $info->index . " 0 obj\n" . $serialized . "endobj\n";
        }

        $result .= "\n";
    }

    private function serializeValue($value, $allowReferences = false)
    {
        if ($allowReferences && is_object($value) && $this->indirectObjectStorage->contains($value)) {
            return $this->indirectObjectStorage[$value]->index . ' 0 R';
        }

        if ($value instanceof Dictionary) {

            // Serialize a dictionary

            $serializedValues = array();
            foreach ($value as $key => $childValue) {
                if ($childValue !== null) {
                    if (is_object($childValue)
                        && $childValue instanceof \Countable
                        && $childValue->count() == 0
                    ) {
                        // Empty dictionaries or arrays should not be printed.
                        // Streams are printed always as they have to be indirect objects.
                        continue;
                    } else {
                        $serialized = $this->serializeValue($childValue, true);

                        if (null !== $serialized) {
                            $serializedValues[] = "/$key " . $serialized;
                        }
                    }
                }
            }

            $serialized = '<< ' . implode(' ', $serializedValues) . ' >>';

            if ($value instanceof Stream) {
                $serialized .= "\n";
                $serialized .= "stream\n";
                $serialized .= $value->getContent() . "\n";
                $serialized .= "endstream\n";
            }

            return $serialized;
            
        } else if ($value instanceof \ArrayObject) {

            // Serialize an array

            $length = $value->count();
            if (0 === $length && !$this->indirectObjectStorage->contains($value)) {
                return null;
            }

            $serializedValues = array();
            for ($i = 0; $i < $length; $i++) {
                $serializedValues[] = $this->serializeValue($value[$i], true);
            }

            return '[' . implode(' ', $serializedValues) . ']';

        } else if ($value instanceof Name) {

            // Serialize a name

            return '/' . $value->getName();

        } else if ($value instanceof \DateTime) {

            // Serialize a DateTime

            if ($value->getTimezone()) {
                if ($value->getTimezone()->getName() == 'UTC') {
                    return '(D:' . $value->format('YmdHis') . "+00'00)";
                } else {
                    $tzOffset = str_replace(":", "'", $value->format('P'));
                    return '(D:' . $value->format('YmdHis') . $tzOffset . ')';
                }
            }

            return '(D:' . $value->format('YmdHis') . ')';

        } else if (is_string($value)) {

            // Serialize a string

            if (substr_count($value, '(') != substr_count($value, ')')) {
                $msg = 'Unbalanced number of parentheses is not allowed in a literal string "%s".';
                throw new \Exception(sprintf($msg, $value));
            }

            return "($value)";

        } else if (is_int($value) || is_float($value)) {

            // Serialize integer and floats or doubles

            return $value;

        } else if (is_bool($value)) {

            // Serialize a boolean vealue

            return $value ? 'true' : 'false';

        }

        $type = is_object($value) ? get_class($value) : gettype($value);
        throw new \Exception(sprintf('Value of type "%s" is not serializable.', $type));
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

    /**
     * See Adobe PDF Reference, Edition 2008-7-1 (§7.5.5 File Trailer)
     */
    private function writeTrailer()
    {
        $result = &$this->result;

        $id = md5(implode('|', array(
            date('YmdHis'),
            strlen($result),
            $result,
        )));

        $trailer = new Dictionary();
        $trailer['Size'] = $this->indirectObjectStorage->count() + 1;
        $trailer['Root'] = $this->document->getCatalog();
        $trailer['Info'] = $this->document->getCatalog()->getMetadata();
        $trailer['ID'] = new \ArrayObject(array($id, $id));

        $result .= "trailer\n";
        $result .= $this->serializeValue($trailer, false) . "\n";

        $result .= "startxref\n";
        $result .= $this->lastXrefSectionOffset . "\n";
    }
}
