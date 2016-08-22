<?php

namespace Pideph\Node;

use Pideph\Node\Collection\InlineCollection;
use Pideph\Document\Output;

/**
 * InlineNode
 *
 * @author naitsirch <login.naitsirch@arcor.de>
 */
abstract class InlineNode
{
    /**
     * Parent node
     * @var InlineNode
     */
    protected $parent;

    protected $text;
    
    /**
     * Child nodes
     * @var InlineCollection
     */
    protected $children;

    /**
     * @param InlineNode $parent
     */
    public function __construct(self $parent = null)
    {
        $this->parent = $parent;
    }
    
    /**
     * Get the parent node.
     * @return InlineNode
     */
    public function parent()
    {
        return $this->parent;
    }

    public function text($text = null)
    {
        if (null === $text) {
            return $this->text;
        }
        
        $this->text = $text;
        return $this;
    }

    /**
     * Get all child nodes.
     * @return InlineCollection
     */
    public function children()
    {
        if (!$this->children) {
            $this->children = new InlineCollection($this);
        }
        return $this->children;
    }

    /**
     * Ends the definition flow of this node and returns its collection.
     * @return InlineCollection|null
     */
    public function end()
    {
        return $this->parent() ? $this->parent()->children() : null;
    }

    /**
     * Generate the node.
     * @param \Pideph\Document\Structure $output
     * @return \Pideph\Document\Structure
     */
    public function generate(Structure $output)
    {
        // generate this!

        foreach ($this->children() as $child) {
            $child->generate($output);
        }
        
        return $output;
    }
}
