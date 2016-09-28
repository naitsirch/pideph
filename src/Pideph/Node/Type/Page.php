<?php

namespace Pideph\Node\Type;

use Pideph\Document;
use Pideph\Node\BlockNode;

/**
 * Pideph\Node\Type\Page
 *
 * @author naitsirch <naitsirch@e.mail.de>
 */
class Page extends BlockNode
{
    protected $document;
    protected $offset;
    
    public function __construct($parent = null, Document $document = null, $offset = 0)
    {
        parent::__construct(null);
        $this->document = $document;
        $this->offset = $offset;
    }
}
