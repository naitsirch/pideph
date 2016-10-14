<?php

namespace Pideph\Document\Structure\Objects;

use ArrayObject;

/**
 * Description of ResourceDictionary
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
     * @var Dictionary
     */
    private $font;

    /**
     * @var Dictionary
     */
    private $xObject;

    /**
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

    public function __construct()
    {
        $this->procSet = new ArrayObject();

        $this->colorSpace = new Dictionary();
        $this->font = new Dictionary();
        $this->xObject = new Dictionary();
        $this->extGState = new Dictionary();
        $this->shading = new Dictionary();
        $this->pattern = new Dictionary();
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

    protected function getStaticDictionaryFields()
    {
        return array(
            'colorSpace',
            'font',
            'xObject',
            'procSet',
            'extGState',
            'shading',
            'pattern',
        );
    }
}
