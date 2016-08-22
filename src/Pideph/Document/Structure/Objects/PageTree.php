<?php

namespace Pideph\Document\Structure\Objects;

/**
 * Pideph\Document\Structure\Objects\PageTree
 *
 * @author naitsirch <login.naitsirch@arcor.de>
 */
class PageTree extends BaseObject
{
    public $type = '/Pages';

    /**
     * (Required) An array of indirect references to the immediate children of
     * this node. The children shall only be page objects or other page tree nodes.
     * @var array
     */
    public $kids = array();

    /**
     * (Required) The number of leaf nodes (page objects) that are descendants
     * of this node within the page tree.
     * @var integer
     */
    public $count;
}
