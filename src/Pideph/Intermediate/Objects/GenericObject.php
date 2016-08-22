<?php

namespace Pideph\Intermediate\Objects;

/**
 * Pideph\Intermediate\Objects\GenericObject
 *
 * @author naitsirch <login.naitsirch@arcor.de>
 */
class GenericObject extends BaseObject
{
    public function __construct($type)
    {
        $this->type = $type;
    }

}
