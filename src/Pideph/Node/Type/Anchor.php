<?php

namespace Pideph\Node\Type;

use Pideph\Node\InlineNode;

/**
 * Anchor
 *
 * @author naitsirch <naitsirch@e.mail.de>
 */
class Anchor extends InlineNode
{
    protected $href;
    
    public function href($href = null)
    {
        if (null === $href) {
            return $this->href;
        }
        
        $this->href = $href;
        return $this;
    }
}
