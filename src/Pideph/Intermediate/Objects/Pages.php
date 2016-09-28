<?php

namespace Pideph\Intermediate\Objects;

/**
 * Pideph\Intermediate\Objects\Pages
 *
 * @author naitsirch <naitsirch@e.mail.de>
 */
class Pages extends BaseObject
{
    /**
     * (Required) An array of indirect references to the immediate children of
     * this node. The children shall only be page objects or other page tree nodes.
     * @var array
     */
    private $kids = array();

    /**
     * (Required) The number of leaf nodes (page objects) that are descendants
     * of this node within the page tree.
     * @var integer
     */
    private $count;

    public function __construct(ObjectInterface $parent)
    {
        $this->parent = $parent;
    }

    public function getKids()
    {
        return $this->kids;
    }

    public function addKid(ObjectInterface $kid)
    {
        if (!$kid instanceof Page && !$kid instanceof self) {
            throw new \InvalidArgumentException('Kids of a page tree has to be page trees or pages.');
        }
        $this->kids[] = $kid;
        return $this;
    }

    public function getType()
    {
        return 'Pages';
    }
}
