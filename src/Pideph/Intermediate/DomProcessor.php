<?php

namespace Pideph\Intermediate;

use DOMDocument;
use Pideph\Intermediate\Objects\ObjectInterface;
use Pideph\Intermediate\Objects\Document;
use Pideph\Intermediate\DomMapping\BuildInMappings;
use Pideph\Intermediate\DomMapping\DomMappingInterface;
use Pideph\Intermediate\DomMapping\MappingResult;

/**
 * Pideph\Intermediate\DomProcessor
 *
 * @author naitsirch <naitsirch@e.mail.de>
 */
class DomProcessor
{
    private $dom;
    private $document;
    private $domMappings = array();
    private $warnings = array();

    public function __construct(DOMDocument $dom)
    {
        $this->dom = $dom;
        $this->addDomMappings(new BuildInMappings());
    }

    /**
     * Generates the intermediate object graph from the DOM document.
     */
    public function generate()
    {
        $this->document = new Document();

        // start recoursion
        $this->walk($this->dom, $this->document);

        return;
    }

    public function addDomMappings(DomMappingInterface $mappings)
    {
        foreach ($mappings->getMappings() as $tag => $resolving) {
            if (isset($this->domMappings[$tag]) && empty($resolving['overwrite'])) {
                $this->warnings[] = sprintf('DOM mapping for "%s" tag exists already, you should set \'overwrite\' to true.', $tag);
                continue;
            }
            $this->domMappings[$tag] = $resolving['call'];
        }
    }

    public function walk(\DOMNode $domNode, ObjectInterface $target)
    {
        $nodeName = $domNode->nodeName;
        if (isset($this->domMappings[$nodeName])) {
            $callable = $this->domMappings[$nodeName];
            if (is_array($callable) && is_object($callable[0])) {
                $result = $callable[0]->{$callable[1]}($domNode, $target);
            }
            if (!$result instanceof MappingResult) {
                throw new \RuntimeException(sprintf('The mapping result of the <%s> element did not return a MappingResult.', $nodeName));
            }
            foreach ($result->getNextDomNodes() as $domNode) {
                $this->walk($domNode, $result->getIntermediateObject());
            }
        } else {
            $this->warnings[] = sprintf('No DOM mapping for "%s" tag.', $nodeName);
        }
    }
}
