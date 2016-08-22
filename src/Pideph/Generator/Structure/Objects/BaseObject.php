<?php

namespace Pideph\Generator\Structure\Objects;

/**
 * Pideph\Generator\Structure\Objects\BaseObject
 *
 * @author naitsirch <login.naitsirch@arcor.de>
 */
class BaseObject extends \stdClass
{
    protected $type;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }
}
