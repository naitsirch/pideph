<?php

namespace Pideph\Document\Structure\Objects;

/**
 * Pideph\Document\Structure\Objects\Page
 *
 * @author naitsirch
 */
class Page extends TypedDictionary
{
    const TYPE = 'Page';

    /**
     * Array of annotations
     * @var Dictionary
     */
    private $annots = array();

    /**
     * The content of the page as a PDF stream.
     * @var string
     */
    private $contents;

    /**
     * The parent page tree.
     * @var PageTree
     */
    private $parent;

    /**
     * @var int
     */
    private $rotate = 0;

    /**
     * Rectangle object (an array of 4 fixed point numbers, they are the user
     * coordinates for the left, bottom, right, and top sides of the rectangle).
     *
     * This page has two Rectangle Objects, MediaBox and CropBox. The
     * intersection of these two rectangles will determine the visible drawing
     * area of the page.
     *
     * @var array
     */
    private $mediaBox = array();

    /**
     * Rectangle object (an array of 4 fixed point numbers, they are the user
     * coordinates for the left, bottom, right, and top sides of the rectangle).
     *
     * This page has two Rectangle Objects, MediaBox and CropBox. The
     * intersection of these two rectangles will determine the visible drawing
     * area of the page.
     * 
     * @var array
     */
    private $cropBox = array();

    /**
     * Rectangle object (an array of 4 fixed point numbers, they are the user
     * coordinates for the left, bottom, right, and top sides of the rectangle).
     *
     * @var array
     */
    private $bleedBox = array();

    /**
     * Rectangle object (an array of 4 fixed point numbers, they are the user
     * coordinates for the left, bottom, right, and top sides of the rectangle).
     *
     * @var array
     */
    private $trimBox = array();

    /**
     * Rectangle object (an array of 4 fixed point numbers, they are the user
     * coordinates for the left, bottom, right, and top sides of the rectangle).
     *
     * This page has two Rectangle Objects, MediaBox and CropBox. The
     * intersection of these two rectangles will determine the visible drawing
     * area of the page.
     *
     * @var array
     */
    private $artBox = array();

    /**
     * PDF Type: Dictionary
     * @var ResourceDictionary
     */
    private $resources;

    public function __construct(PageTree $parent)
    {
        $this->setType(self::TYPE);
        
        $this->parent = $parent;
        $this->annots = new Dictionary();
        $this->resources = new ResourceDictionary();
    }

    /**
     * @return Dictionary
     */
    public function getAnnots()
    {
        return $this->annots;
    }

    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @return PageTree
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function getRotate()
    {
        return $this->rotate;
    }

    /**
     * @return array
     */
    public function getMediaBox()
    {
        return $this->mediaBox;
    }

    public function setMediaBox(array $mediaBox)
    {
        $this->mediaBox = $mediaBox;
    }

    public function getCropBox()
    {
        return $this->cropBox;
    }

    public function getBleedBox()
    {
        return $this->bleedBox;
    }

    public function getTrimBox()
    {
        return $this->trimBox;
    }

    public function getArtBox()
    {
        return $this->artBox;
    }

    /**
     * @return ResourceDictionary
     */
    public function getResources()
    {
        return $this->resources;
    }

    public function setContents($contents)
    {
        $this->contents = $contents;
    }

    public function setRotate($rotate)
    {
        $this->rotate = $rotate;
    }

    public function setCropBox($cropBox)
    {
        $this->cropBox = $cropBox;
    }

    public function setBleedBox($bleedBox)
    {
        $this->bleedBox = $bleedBox;
    }

    public function setTrimBox($trimBox)
    {
        $this->trimBox = $trimBox;
    }

    public function setArtBox($artBox)
    {
        $this->artBox = $artBox;
    }


    protected function getStaticDictionaryFields()
    {
        return array(
            'annots',
            'contents',
            'parent',
            'rotate',
            'mediaBox',
            'cropBox',
            'bleedBox',
            'trimBox',
            'artBox',
            'resources',
        );
    }
}
