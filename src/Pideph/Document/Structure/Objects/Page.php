<?php

namespace Pideph\Document\Structure\Objects;

use ArrayObject;
use Pideph\Document\Structure\Objects\Dictionary;

/**
 * Pideph\Document\Structure\Objects\Page
 *
 * See Adobe PDF Reference, Edition 2008-7-1 (§7.7.3.3 Page Objects)
 *
 * @author naitsirch
 */
class Page extends TypedDictionary
{
    const TYPE = 'Page';

    /**
     * Array of annotation dictionaries.
     * @var ArrayObject
     */
    private $annots;

    /**
     * The content of the page as a PDF stream.
     * @var Stream
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
     * (Optional; PDF 1.4) A group attributes dictionary that shall specify
     * the attributes of the page's page group for use in the transparent
     * imaging model (see 11.4.7, "Page Group" and 11.6.6,
     * "Transparency Group XObjects").
     *
     * @var Dictionary
     */
    private $group;

    /**
     * (Optional) A stream object that shall define the page’s thumbnail
     * image (see 12.3.4, "Thumbnail Images").
     *
     * @var Stream
     */
    private $thumb;

    /**
     * Rectangle object (an array of 4 fixed point numbers, they are the user
     * coordinates for the left, bottom, right, and top sides of the rectangle).
     *
     * This page has two Rectangle Objects, MediaBox and CropBox. The
     * intersection of these two rectangles will determine the visible drawing
     * area of the page.
     *
     * @var ArrayObject
     */
    private $mediaBox;

    /**
     * Rectangle object (an array of 4 fixed point numbers, they are the user
     * coordinates for the left, bottom, right, and top sides of the rectangle).
     *
     * This page has two Rectangle Objects, MediaBox and CropBox. The
     * intersection of these two rectangles will determine the visible drawing
     * area of the page.
     * 
     * @var ArrayObject
     */
    private $cropBox;

    /**
     * Rectangle object (an array of 4 fixed point numbers, they are the user
     * coordinates for the left, bottom, right, and top sides of the rectangle).
     *
     * @var ArrayObject
     */
    private $bleedBox;

    /**
     * Rectangle object (an array of 4 fixed point numbers, they are the user
     * coordinates for the left, bottom, right, and top sides of the rectangle).
     *
     * @var ArrayObject
     */
    private $trimBox;

    /**
     * Rectangle object (an array of 4 fixed point numbers, they are the user
     * coordinates for the left, bottom, right, and top sides of the rectangle).
     *
     * This page has two Rectangle Objects, MediaBox and CropBox. The
     * intersection of these two rectangles will determine the visible drawing
     * area of the page.
     *
     * @var ArrayObject
     */
    private $artBox;

    /**
     * PDF Type: Dictionary
     * @var ResourceDictionary
     */
    private $resources;

    public function __construct(PageTree $parent)
    {
        $this->setType(self::TYPE);
        
        $this->parent = $parent;
        $this->contents = new Stream();
        $this->annots = new ArrayObject();
        $this->mediaBox = new ArrayObject();
        $this->cropBox = new ArrayObject();
        $this->bleedBox = new ArrayObject();
        $this->trimBox = new ArrayObject();
        $this->artBox = new ArrayObject();
        $this->resources = new ResourceDictionary();

        $this->group = new Dictionary();
        $this->group->add('CS', Name::by('DeviceRGB'));
        $this->group->add('I', true);
        $this->group->add('S', Name::by('Transparency'));
    }

    /**
     * @return ArrayObject
     */
    public function getAnnots()
    {
        return $this->annots;
    }

    /**
     * @return Stream
     */
    public function getContents()
    {
        return $this->contents;
    }

    public function setContents(Stream $contents)
    {
        $this->contents = $contents;
    }

    /**
     * @return PageTree
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return int
     */
    public function getRotate()
    {
        return $this->rotate;
    }

    public function setRotate($rotate)
    {
        $this->rotate = $rotate;
    }

    /**
     * @return Dictionary
     */
    public function getGroup()
    {
        return $this->group;
    }

    public function setGroup(Dictionary $group)
    {
        $this->group = $group;
    }

    /**
     * @return Stream|null
     */
    public function getThumb()
    {
        return $this->thumb;
    }

    public function setThumb(Stream $thumb = null)
    {
        $this->thumb = $thumb;
    }

    /**
     * @return ArrayObject
     */
    public function getMediaBox()
    {
        return $this->mediaBox;
    }

    public function setMediaBox(ArrayObject $mediaBox)
    {
        $this->mediaBox = $mediaBox;
    }

    /**
     * @return ArrayObject
     */
    public function getCropBox()
    {
        return $this->cropBox;
    }

    public function setCropBox(ArrayObject $cropBox)
    {
        $this->cropBox = $cropBox;
    }

    /**
     * @return ArrayObject
     */
    public function getBleedBox()
    {
        return $this->bleedBox;
    }

    public function setBleedBox(ArrayObject $bleedBox)
    {
        $this->bleedBox = $bleedBox;
    }

    /**
     * @return ArrayObject
     */
    public function getTrimBox()
    {
        return $this->trimBox;
    }

    public function setTrimBox(ArrayObject $trimBox)
    {
        $this->trimBox = $trimBox;
    }

    /**
     * @return ArrayObject
     */
    public function getArtBox()
    {
        return $this->artBox;
    }

    public function setArtBox(ArrayObject $artBox)
    {
        $this->artBox = $artBox;
    }

    /**
     * @return ResourceDictionary
     */
    public function getResources()
    {
        return $this->resources;
    }

    protected function getStaticDictionaryFields()
    {
        return array(
            'annots',
            'contents',
            'parent',
            'rotate',
            'group',
            'thumb',
            'mediaBox',
            'cropBox',
            'bleedBox',
            'trimBox',
            'artBox',
            'resources',
        );
    }
}
