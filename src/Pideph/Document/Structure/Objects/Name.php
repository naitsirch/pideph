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
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Get the name.
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value represented by this name.
     * @return string
     */
    public function getValue()
    {
        if (null === $this->value) {
            $this->value = self::convertNameToValue($this->name);
        }
        return $this->value;
    }

    private static function convertNameToValue($name)
    {
        return preg_replace_callback('/(#\d\d)/', function ($matches) {
            return chr(hexdec($matches[1]));
        }, $name);
    }
}
