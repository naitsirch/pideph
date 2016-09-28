<?php

namespace Pideph\Node\Collection;

use Pideph\Node\BlockNode;

/**
 * Pideph\Node\Collection\BlockCollection
 *
 * @author naitsirch <naitsirch@e.mail.de>
 */
class BlockCollection extends InlineCollection
{
    /**
     * @param \Pideph\Node\BlockNode $owner
     */
    public function __construct(BlockNode $owner)
    {
        parent::__construct($owner);
    }

    /**
     * Adds a division node to the collection and returns it.
     * @return \Pideph\Node\Type\Division
     */
    public function addDivision()
    {
        return $this->add(new \Pideph\Node\Type\Division($this->owner));
    }

    /**
     * Adds a division node to the collection and returns it.
     * @return \Pideph\Node\Type\Paragraph
     */
    public function addParagraph()
    {
        return $this->add(new \Pideph\Node\Type\Paragraph($this->owner));
    }
    
    /**
     * Returns the owner node of this collection.
     * @return \Pideph\Node\BlockNode
     */
    public function end()
    {
        // this method is currently only there to provide the code completion
        // of block nodes in IDEs
        return parent::end();
    }
}
