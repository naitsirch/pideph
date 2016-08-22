<?php

namespace Pideph\Intermediate\Objects\Dictionaries;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Pideph\Intermediate\Objects\Dictionaries\Dictionary
 *
 * @author naitsirch
 */
class Dictionary implements \ArrayAccess, \IteratorAggregate
{
    /**
     * Holds all the data of the dictionary.
     * @var array
     */
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value)
    {
        throw new \BadMethodCallException('Dictionary data is not changeable');
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    /**
     * @return OptionsResolver
     */
    protected static function getOptionsResolver()
    {
        return new OptionsResolver();
    }
}
