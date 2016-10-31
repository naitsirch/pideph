<?php

namespace Pideph\Document\Structure\Objects;

use ArrayObject;

/**
 * Pideph\Document\Structure\Objects\ResourceDictionary
 *
 * See Adobe PDF Reference, Edition 2008-7-1 (§7.8.3 Resource Dictionaries)
 *
 * @author naitsirch
 */
class ResourceDictionary extends TypedDictionary
{
    const TYPE = null;

    /**
     * @var Dictionary
     */
    private $colorSpace;

    /**
     * This returns a dictionary.
     * Attention! This should not be a Font dictionary but rather a dictionary
     * consisting of font-dictionaries with their names as key.
     *
     * This is why there is no `setFont()`
     *
     * @example $resource->getFont()->add('F1', $fontDictionary);
     *          => /Font << /F1 24 0 R /F2 25 0 R ... >>
     *
     * @var Font
     */
    private $font;

    /**
     * @var Dictionary
     */
    private $xObject;

    /**
     * (Optional) An array of predefined procedure set names (see 14.2, "Procedure Sets").
     * @var ArrayObject
     */
    private $procSet;

    /**
     * @var Dictionary
     */
    private $extGState;

    /**
     * @var Dictionary
     */
    private $shading;

    /**
     * @var Dictionary
     */
    private $pattern;

    /**
     * @var Dictionary
     */
    private $properties;

    public function __construct()
    {
        $this->procSet = new ArrayObject();

        $this->colorSpace = new Dictionary();
        $this->font = new Dictionary();
        $this->xObject = new Dictionary();
        $this->extGState = new Dictionary();
        $this->shading = new Dictionary();
        $this->pattern = new Dictionary();
        $this->properties = new Dictionary();
    }

    /**
     * @return Dictionary
     */
    public function getColorSpace()
    {
        return $this->colorSpace;
    }

    /**
     * @return Dictionary
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * @return Dictionary
     */
    public function getXObject()
    {
        return $this->xObject;
    }

    /**
     * @return ArrayObject
     */
    public function getProcSet()
    {
        return $this->procSet;
    }

    public function setProcSet(ArrayObject $procSet)
    {
        $this->procSet = $procSet;
    }

    /**
     * @return Dictionary
     */
    public function getExtGState()
    {
        return $this->extGState;
    }

    /**
     * @return Dictionary
     */
    public function getShading()
    {
        return $this->shading;
    }

    /**
     * @return Dictionary
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @return Dictionary
     */
    public function getProperties()
    {
        return $this->properties;
    }

    public function setProperties(Dictionary $properties)
    {
        $this->properties = $properties;
    }

    protected function getStaticDictionaryFields()
    {
        return array(
            'ColorSpace',
            'Font',
            'XObject',
            'ProcSet',
            'ExtGState',
            'Shading',
            'Pattern',
        );
    }
}
