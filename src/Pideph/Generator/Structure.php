<?php

namespace Pideph\Generator;

/**
 * Pideph\Generator\Structure
 *
 * @author naitsirch <login.naitsirch@arcor.de>
 */
class Structure
{
    private $objects;
    private $objectsByType;

    public function addObject(\stdClass $object)
    {
        if (!$object->type) {
            $object->type = '_';
        }
        $this->objects[] = $object;
        $this->objectsByType[$object->type][] = $object;
        
        return $this;
    }
}
