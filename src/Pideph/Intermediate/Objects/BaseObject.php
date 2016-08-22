<?php

namespace Pideph\Intermediate\Objects;

/**
 * Pideph\Intermediate\Objects\BaseObject
 *
 * @author naitsirch <login.naitsirch@arcor.de>
 */
abstract class BaseObject implements ObjectInterface
{
    protected $type;
    protected $parent;

    public function getType()
    {
        return $this->type;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function getRoot()
    {
        $parent = $current = $this->getParent();
        while ($parent) {
            $current = $parent;
            $parent = $parent->getParent();
        }

        return $current ?: $this;
    }
}
