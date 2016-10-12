<?php

namespace Pideph\Document\Structure\Objects;

/**
 * Pideph\Document\Structure\Objects\Name
 *
 * @author naitsirch
 */
class Name
{
    private $name;

    private $value;

    public function __construct($name)
    {
        if (empty($name)) {
            throw new Exception('Empty names are not allowed.');
        }
        $this->name = $name;
        $this->value = self::convertNameToValue($name);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    private static function convertNameToValue($name)
    {
        return preg_replace_callback('/(#\d\d)/', function ($matches) {
            return chr(hexdec($matches[1]));
        }, $name);
    }
}
