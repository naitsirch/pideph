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

    const HEIGHT_DINA4 = 841.8898;
    const WIDTH_DINA4 = 595.2756;

    /**
     * (Optional) An array of annotation dictionaries that shall contain
     * indirect references to all annotations associated with the page (see
     * 12.5, "Annotations").
     * 
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
     * (Required if PieceInfo is present; optional otherwise; PDF 1.3) The
     * date and time (see 7.9.4, "Dates") when the page’s contents were
     * most recently modified. If a page-piece dictionary (PieceInfo) is
     * present, the modification date shall be used to ascertain which of
     * the application data dictionaries that it contains correspond to the
     * current content of the page (see 14.5, "Page-Piece Dictionaries").
     *
     * @var \DateTime
     */
    private $lastModified;

    /**
     * (Optional; inheritable) The number of degrees by which the page
     * shall be rotated clockwise when displayed or printed. The value
     * shall be a multiple of 90. Default value: 0.
     *
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
     * (Optional; PDF 1.3) A rectangle, expressed in default user space
     * units, that shall define the intended dimensions of the finished page
     * after trimming (see 14.11.2, "Page Boundaries").
     * Default value: the value of CropBox.
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
     * (Optional; PDF 1.3) The page's preferred zoom (magnification)
     * factor: the factor by which it shall be scaled to achieve the natural
     * display magnification (see 14.10.6, "Object Attributes Related to
     * Web Capture").
     *
     * @var float
     */
    private $pZ;

    /**
     * PDF Type: Dictionary
     * @var ResourceDictionary
     */
    private $resources;

    /**
     * (Required if the page contains structural content items; PDF 1.3)
     * The integer key of the page’s entry in the structural parent tree (see
     * 14.7.4.4, "Finding Structure Elements from Content Items").
     *
     * @var int
     */
    private $structParents;

    public function __construct(PageTree $parent)
    {
        $this->setType(self::TYPE);
        
        $this->parent = $parent;
        $this->contents = new Stream();
        $this->annots = new ArrayObject();
        $this->mediaBox = new ArrayObject(array(0, 0, self::WIDTH_DINA4, self::HEIGHT_DINA4));
        $this->lastModified = new \DateTime();
        $this->resources = new ResourceDictionary();

        $this->group = new TransparencyGroupXObject();
        $this->group->setS(TransparencyGroupXObject::SUBTYPE_TRANSPARENCY);
        $this->group->setCS(TransparencyGroupXObject::COLORSPACE_DEFAULT_RGB);
        $this->group->setI(true);
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
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    public function setLastModified(\DateTime $lastModified)
    {
        $this->lastModified = $lastModified;
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
        return $this->cropBox ?: $this->getMediaBox();
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
        return $this->bleedBox ?: $this->getCropBox();
    }

    public function setBleedBox(ArrayObject $bleedBox)
    {
        $this->bleedBox = $bleedBox;
    }

    /**
     * @var ArrayObject
     */
    public function getTrimBox()
    {
        return $this->trimBox ?: $this->getCropBox();
    }

    /**
     * See getter
     * 
     * @param ArrayObject $trimBox
     */
    public function setTrimBox(ArrayObject $trimBox)
    {
        $this->trimBox = $trimBox;
    }

    /**
     * @return ArrayObject
     */
    public function getArtBox()
    {
        return $this->artBox ?: $this->getCropBox();
    }

    public function setArtBox(ArrayObject $artBox)
    {
        $this->artBox = $artBox;
    }

    /**
     * @return float
     */
    public function getPZ()
    {
        return $this->pZ;
    }

    public function setPZ($pZ)
    {
        $this->pZ = $pZ;
    }

    /**
     * @return ResourceDictionary
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * @return int
     */
    public function getStructParents()
    {
        return $this->structParents;
    }

    public function setStructParents($structParents)
    {
        $this->structParents = $structParents;
    }

    public function isOnlyIndirectlyReferencable()
    {
        return true;
    }

    protected function getStaticDictionaryFields()
    {
        return array(
            'Annots',
            'Contents',
            'Parent',
            'LastModified',
            'Rotate',
            'Group',
            'Thumb',
            'MediaBox',
            'CropBox',
            'BleedBox',
            'TrimBox',
            'ArtBox',
            'Resources',
            'PZ',
        );
    }
}
