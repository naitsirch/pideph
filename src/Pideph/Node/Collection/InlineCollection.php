<?php

namespace Pideph\Node\Collection;

use Pideph\Node\InlineNode;

/**
 * Pideph\Node\Collection\InlineCollection
 *
 * @author naitsirch <login.naitsirch@arcor.de>
 */
class InlineCollection implements \IteratorAggregate
{
    protected $owner;
    protected $nodes = array();

    /**
     * @param \Pideph\Node\InlineNode $owner
     */
    public function __construct(InlineNode $owner)
    {
        $this->owner = $owner;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->nodes);
    }

    /**
     * Adds a node to the array and returns it.
     * @param \Pideph\Node\InlineNode $child
     * @return \Pideph\Node\InlineNode
     */
    protected function add(InlineNode $child)
    {
        $this->nodes[] = $child;
        return $child;
    }
    
    /**
     * Adds an anchor node to the collection and returns it.
     * @return \Pideph\Node\Type\Anchor
     */
    public function addAnchor()
    {
        return $this->add(new \Pideph\Node\Type\Anchor($this->owner));
    }
    
    /**
     * Adds a span node to the collection and returns it.
     * @return \Pideph\Node\Type\Span
     */
    public function addSpan()
    {
        return $this->add(new \Pideph\Node\Type\Span($this->owner));
    }
    
    /**
     * Returns the owner node of this collection.
     * @return \Pideph\Node\InlineNode
     */
    public function end()
    {
        return $this->owner;
    }
}
