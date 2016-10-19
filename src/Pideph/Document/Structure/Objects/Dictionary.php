<?php

namespace Pideph\Document\Structure\Objects;

/**
 * Description of Dictionary
 *
 * @author naitsirch
 */
class Dictionary implements \ArrayAccess, \IteratorAggregate, \Countable
{
    protected $data = array();

    public function add($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetGet($offset)
    {
        if (isset($this->data[$offset])) {
            return $this->data[$offset];
        }
        return null;
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    public function count()
    {
        return count($this->data);
    }
}
