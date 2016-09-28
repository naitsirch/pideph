<?php

namespace Pideph\Document;

/**
 * Pideph\Document\Structure
 *
 * @author naitsirch <naitsirch@e.mail.de>
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
