<?php

namespace Pideph\Node\Type;

use Pideph\Node\BlockNode;
use Pideph\Node\InlineNode;

/**
 * Paragraph
 *
 * @author naitsirch <naitsirch@e.mail.de>
 */
class Paragraph extends BlockNode
{

    /**
     * Gets all child nodes.
     * This paragraph element is a block element, but does only may contain
     * inline elements, so an InlineCollection is returned.
     * 
     * @return \Pideph\Node\Collection\InlineCollection
     */
    public function children()
    {
        return InlineNode::children();
    }
}
