<?php

namespace Pideph;

use DOMDocument;
use Pideph\Document\Document;
use Pideph\Document\StringGenerator;
use Pideph\Intermediate\DomProcessor;

/**
 * Pideph\Document
 *
 * @author naitsirch <naitsirch@e.mail.de>
 */
class Generator
{
    public function generate(Document $document)
    {
        $generator = new StringGenerator($document);
        $generator->generate();
        return $generator->getResult();
    }

    public static function fromHtml($html)
    {
        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        $processor = new DomProcessor($dom);
        $processor->generate();
    }
}
