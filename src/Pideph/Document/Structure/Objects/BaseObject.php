<?php

namespace Pideph\Document\Structure\Objects;

/**
 * Pideph\Document\Structure\Objects\BaseObject
 *
 * @author naitsirch <naitsirch@e.mail.de>
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
