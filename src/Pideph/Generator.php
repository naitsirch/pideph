<?php

namespace Pideph;

use DOMDocument;
use Pideph\Document;
use Pideph\Intermediate\DomProcessor;

/**
 * Pideph\Document
 *
 * @author naitsirch <naitsirch@e.mail.de>
 */
class Generator
{
    private $document;
    private $structure;
    private $output;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function generate()
    {
        // generate structure from node tree
        $this->structure = new Structure();
        $this->document->generate($this->structure);
    
        $this->output = new Output();

        return $this->output;
    }

    public static function fromHtml($html)
    {
        $dom = DOMDocument::loadHTML($html);
        $processor = new DomProcessor($dom);
        $processor->generate();
    }
}
