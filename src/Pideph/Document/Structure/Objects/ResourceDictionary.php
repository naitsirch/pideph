<?php

namespace Pideph\Document\Structure\Objects;

/**
 * Description of ResourceDictionary
 *
 * @author naitsirch
 */
class ResourceDictionary extends TypedDictionary
{
    const TYPE = null;

    private $colorSpace;

    private $font;

    private $xObject;

    private $procSet = array();

    private $extGState;

    private $shading;

    private $pattern;

    public function __construct()
    {
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
     * @return array
     */
    public function getProcSet()
    {
        return $this->procSet;
    }

    public function setProcSet(array $procSet)
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

    protected static function getStaticDictionaryFields()
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
