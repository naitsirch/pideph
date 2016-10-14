<?php

namespace Pideph\Document\Structure\Objects;

/**
 * Pideph\Document\Structure\Objects\Name
 *
 * @author naitsirch
 */
class Name
{
    private static $allNames;

    private $name;

    private $value;

    private function __construct($name)
    {
        if (empty($name)) {
            throw new Exception('Empty names are not allowed.');
        }
        $this->name = $name;
        self::$allNames[$name] = $this;
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

    /**
     * Retrieves an instance of Name by its name.
     * @param string $name
     * @return Name
     */
    public static function by($name)
    {
        $name = (string) $name;

        if (isset(self::$allNames[$name])) {
            return self::$allNames[$name];
        }
        return new Name($name);
    }

    private static function convertNameToValue($name)
    {
        return preg_replace_callback('/(#\d\d)/', function ($matches) {
            return chr(hexdec($matches[1]));
        }, $name);
    }
}
