<?php

namespace Pideph\Intermediate\DomMapping;

use Traversable;
use Pideph\Intermediate\Objects\ObjectInterface;

/**
 * Pideph\Intermediate\MappingResult
 *
 * @author naitsirch
 */
class MappingResult
{
    /**
     * @var \DOMNode[] array of DOMNodes
     */
    private $nextDomNodes;

    private $intermediateObject;

    /**
     *
     * @param array|Traversable $nextDomNodes
     * @param \Pideph\Intermediate\Objects\ObjectInterface $intermediateObject
     */
    public function __construct($nextDomNodes, ObjectInterface $intermediateObject)
    {
        if (!is_array($nextDomNodes) && !$nextDomNodes instanceof Traversable) {
            throw new \InvalidArgumentException('Parameter $nextDomNodes must be array or implement \\Traversable.');
        }
        $this->nextDomNodes = $nextDomNodes;
        $this->intermediateObject = $intermediateObject;
    }

    /**
     *
     * @return \DOMNode[]
     */
    public function getNextDomNodes()
    {
        return $this->nextDomNodes;
    }

    /**
     *
     * @return ObjectInterface
     */
    public function getIntermediateObject()
    {
        return $this->intermediateObject;
    }
}
