<?php

namespace Pideph\Node;

use Pideph\Node\Collection\BlockCollection;

/**
 * BlockNode
 *
 * @author naitsirch <login.naitsirch@arcor.de>
 */
abstract class BlockNode extends InlineNode
{
    /**
     * @param BlockNode $parent
     */
    public function __construct(self $parent = null)
    {
        parent::__construct($parent);
    }

    /**
     * Get all child nodes.
     * @return BlockCollection
     */
    public function children()
    {
        if (!$this->children) {
            $this->children = new BlockCollection($this);
        }
        return $this->children;
    }
}
