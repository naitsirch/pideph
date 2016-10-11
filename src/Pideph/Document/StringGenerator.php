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
    private $store;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function generate()
    {
        $this->store = new \SplObjectStorage();

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
    }

    private function walkObjectTree($object)
    {
        if ($this->store->contains($object)) {
            return;
        }

        if ($object instanceof Dictionary) {
            foreach ($object as $key => $value) {

            }
        }
    }
}
