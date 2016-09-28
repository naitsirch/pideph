<?php

namespace Pideph\Intermediate\Objects;

/**
 * Pideph\Intermediate\Objects\GenericObject
 *
 * @author naitsirch <naitsirch@e.mail.de>
 */
class GenericObject extends BaseObject
{
    public function __construct($type)
    {
        $this->type = $type;
    }

}
