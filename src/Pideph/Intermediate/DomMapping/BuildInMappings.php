<?php

namespace Pideph\Intermediate\DomMapping;

use Pideph\Intermediate\DomMapping\MappingResult;
use Pideph\Intermediate\Objects\Document;
use Pideph\Intermediate\Objects\Catalog;
use Pideph\Intermediate\Objects\ObjectInterface;

/**
 * Pideph\Intermediate\DomMapping\BuildInMappings
 *
 * @author naitsirch <naitsirch@e.mail.de>
 */
class BuildInMappings implements DomMappingInterface
{
    public function getMappings()
    {
        return array(
            '#document' => array('call' => array($this, 'mapDocument'), 'overwrite' => false),
            'html'      => array('call' => array($this, 'mapHtml'), 'overwrite' => false),
            'body'      => array('call' => array($this, 'mapBody'), 'overwrite' => false),
            'text'      => array('call' => array($this, 'mapText'), 'overwrite' => false),
            'span'      => array('call' => array($this, 'mapSpan'), 'overwrite' => false),
        );
    }

    public function mapDocument(\DOMDocument $domDocument, Document $iDocument)
    {
        return new MappingResult(
            array($domDocument->getElementsByTagName('html')->item(0)),
            $iDocument
        );
    }

    public function mapHtml(\DOMElement $domHtml, Document $iDocument)
    {
        return new MappingResult(
            array($domHtml->getElementsByTagName('body')->item(0)),
            $iDocument->getCatalog()
        );
    }

    public function mapBody(\DOMElement $domBody, Catalog $target)
    {
        $pages = $domBody->getElementsByTagName('page');
        if ($pages->length == 0) {
            return array(
                $domBody->childNodes,
                
            );
        }
        return;
    }
}
