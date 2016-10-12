<?php

namespace Pideph\Document\Structure\Objects;

/**
 * Pideph\Document\Structure\Objects\TypedObject
 *
 * @author naitsirch <naitsirch@e.mail.de>
 */
abstract class TypedDictionary extends Dictionary
{
    private $type;

    public function add($key, $value)
    {
        $this->offsetSet($key, $value);
    }

    public function getType()
    {
        return $this->type;
    }

    protected function setType($type)
    {
        $this->type = $type;
    }

    public function offsetExists($offset)
    {
        $fields = $this->getStaticDictionaryFields();

        return 'type' === $offset
            || in_array($offset, $fields)
            || array_key_exists($offset, $this->data)
        ;
    }

    public function offsetGet($offset)
    {
        $fields = $this->getStaticDictionaryFields();

        if ('type' === $offset) {
            return $this->type;
        } else if (in_array($offset, $fields)) {
            $getOffset = 'get' . ucfirst($offset);
            return $this->$getOffset();
        } else if (isset($this->data[$offset])) {
            return $this->data[$offset];
        }
        return null;
    }

    public function offsetSet($offset, $value)
    {
        $fields = $this->getStaticDictionaryFields();

        if (in_array($offset, $fields)) {
            $setOffset = 'set' . ucfirst($offset);
            if (!method_exists($this, $setOffset)) {
                throw new \Exception(sprintf(
                    'Offset "%s" is not writable on dictionary of type "%s".',
                    $offset,
                    get_class($this)
                ));
            }
            return $this->$setOffset($value);
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        $fields = $this->getStaticDictionaryFields();

        if (in_array($offset, $fields)) {
            $setOffset = 'set' . ucfirst($offset);
            if (!method_exists($this, $setOffset)) {
                throw new \Exception(sprintf(
                    'Offset "%s" is not unsettable on dictionary of type "%s".',
                    $offset,
                    get_class($this)
                ));
            }
            return $this->$setOffset(null);
        } else {
            unset($this->data[$offset]);
        }
    }

    public function getIterator()
    {
        $data = array('type' => $this->type);

        foreach ($this->getStaticDictionaryFields() as $field) {
            $getField = 'get' . ucfirst($field);
            $data[$field] = $this->$getField();
        }

        return new \ArrayIterator(array_merge($data, $this->data));
    }

    protected abstract function getStaticDictionaryFields();
}
