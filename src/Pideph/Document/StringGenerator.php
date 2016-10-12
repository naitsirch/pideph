<?php

namespace Pideph\Document;

use Pideph\Document\Structure\Objects\Dictionary;

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
    private $dictionaryStore;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function generate()
    {
        $this->dictionaryStore = new \SplObjectStorage();

        $this->result = "%PDF-1.4 %"."\xC6\xA5"."\xC8\x8B"."\xE1\xB8\x8B"."\xD0\xB5"."\xD1\x80"."\xD2\xBB"."\n\n";

        $this->result .= $this->generateDirectObjects();

        $this->result .= "%%EOF";
    }

    public function getResult()
    {
        return $this->result;
    }

    private function generateDirectObjects()
    {
        $this->walkObjectTree($this->document->getCatalog());

        $result = '';
        foreach ($this->dictionaryStore as $dictionary) {
            $storeInfo = $this->dictionaryStore[$dictionary];
            $result .= $storeInfo['index'] . " 0 obj" . $storeInfo['serialized'] . "endobj\n";
        }

        return $result;
    }

    private function walkObjectTree($value)
    {
        if ($value instanceof Dictionary) {
            if ($this->dictionaryStore->contains($value)) {
                $storeInfo = $this->dictionaryStore->offsetGet($value);
                return $storeInfo['reference'];
            }
            $index = $this->dictionaryStore->count() + 1;
            $reference = "[$index 0 R]";

            $storeInfo = array(
                'index' => $index,
                'reference' => $reference,
                'serialized' => null,
            );
            $this->dictionaryStore->attach($value, $storeInfo);

            $serializedValues = array();
            foreach ($value as $key => $childValue) {
                if (is_string($childValue)) {
                    if (strpos($childValue, '/') !== false) {
                        $msg = 'Dictionary keys must not contain a slash. The key "%s" is invalid.';
                        throw new \Exception(sprintf($msg, $childValue));
                    }
                    $serializedValues[] = "/$key /$childValue";
                } else if ($childValue !== null) {
                    $serializedValues[] = "/$key " . $this->walkObjectTree($childValue);
                }
            }

            $storeInfo['serialized'] = '<< ' . implode(' ', $serializedValues) . ' >>';

            $this->dictionaryStore->attach($value, $storeInfo);

            return $reference;
        } else if (is_array($value)) {
            $length = count($value);
            $serializedValues = [];
            for ($i = 0; $i < $length; $i++) {
                if (!isset($value[$i])) {
                    $msg = 'Only purely indexed arrays are allowed. But we got an array with these keys: "%s". Use a Dictionary instead.';
                    throw new \Exception(sprintf($msg, implode(', ', array_keys($value))));
                }
                $serializedValues[] = $this->walkObjectTree($value[$i]);
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
}
