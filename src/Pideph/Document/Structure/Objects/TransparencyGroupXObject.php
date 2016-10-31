<?php

namespace Pideph\Document\Structure\Objects;

use ArrayObject;

/**
 * Pideph\Document\Structure\Objects\TransparencyGroupXObject
 *
 * See Adobe PDF Reference, Edition 2008-7-1
 *   §11.6.6 Transparency Group XObjects
 *
 * @author naitsirch
 */
class TransparencyGroupXObject extends TypedDictionary
{
    const TYPE = 'Group';
    
    const SUBTYPE_TRANSPARENCY = 'Transparency';

    const COLORSPACE_LAB          = 'Lab';
    const COLORSPACE_ICC_BASED    = 'ICCBased';
    const COLORSPACE_PATTERN      = 'Pattern';
    const COLORSPACE_INDEXED      = 'Indexed';
    const COLORSPACE_SEPARATION   = 'Separation';
    const COLORSPACE_DEVICE_N     = 'DeviceN';
    const COLORSPACE_DEFAULT_GRAY = 'DefaultGray';
    const COLORSPACE_DEFAULT_RGB  = 'DefaultRGB';
    const COLORSPACE_DEFAULT_CMYK = 'DefaultCMYK';

    /**
     * (Required) The group subtype, which identifies the type of group whose
     * attributes this dictionary describes; shall be Transparency for a
     * transparency group.
     *
     * @var Name
     */
    private $s;

    /**
     * (Sometimes required) The group colour space, which is used for the
     * following purposes:
     * - As the colour space into which colours shall be converted when
     *   painted into the group
     * - As the blending colour space in which objects shall be composited
     *   within the group (see “Blending Colour Space”)
     * - As the colour space of the group as a whole when it in turn is painted
     *   as an object onto its backdrop
     *
     * The group colour space shall be any device or CIE-based colour space
     * that treats its components as independent additive or subtractive values
     * in the range 0.0 to 1.0, subject to the restrictions described in 11.3.4,
     * "Blending Colour Space." These restrictions exclude Lab and lightness-
     * chromaticity ICCBased colour spaces, as well as the special colour
     * spaces Pattern, Indexed, Separation, and DeviceN. Device colour
     * spaces shall be subject to remapping according to the DefaultGray,
     * DefaultRGB, and DefaultCMYK entries in the ColorSpace subdictionary
     * of the current resource dictionary (see “Default Colour Spaces”).
     * Ordinarily, the CS entry may be present only for isolated transparency
     * groups (those for which I is true), and even then it is optional. However,
     * this entry shall be present in the group attributes dictionary for any
     * transparency group XObject that has no parent group or page from which
     * to inherit—in particular, one that is the value of the G entry in a soft-mask
     * dictionary of subtype Luminosity (see “Soft-Mask Dictionaries”).
     * Additionally, the CS entry may be present in the group attributes
     * dictionary associated with a page object, even if I is false or absent. In
     * the normal case in which the page is imposed directly on the output
     * medium, the page group is effectively isolated regardless of the I value,
     * and the specified CS value shall therefore be honoured. But if the page is
     * in turn used as an element of some other page and if the group is non-
     * isolated, CS shall be ignored and the colour space shall be inherited from
     * the actual backdrop with which the page is composited (see “Page
     * Group”).
     * Default value: the colour space of the parent group or page into which this
     * transparency group is painted. (The parent’s colour space in turn may be
     * either explicitly specified or inherited.)
     * For a transparency group XObject used as an annotation appearance
     * (see “Appearance Streams”), the default colour space shall be inherited
     * from the page on which the annotation appears.

     * @var Name|ArrayObject
     */
    private $cs;

    /**
     * (Optional) A flag specifying whether the transparency group is isolated
     * (see “Isolated Groups”). If this flag is true, objects within the group shall
     * be composited against a fully transparent initial backdrop; if false, they
     * shall be composited against the group’s backdrop. Default value: false.
     * In the group attributes dictionary for a page, the interpretation of this entry
     * shall be slightly altered. In the normal case in which the page is imposed
     * directly on the output medium, the page group is effectively isolated and
     * the specified I value shall be ignored. But if the page is in turn used as an
     * element of some other page, it shall be treated as if it were a
     * transparency group XObject; the I value shall be interpreted in the normal
     * way to determine whether the page group is isolated.
     *
     * @var boolean
     */
    private $i = false;

    /**
     * (Optional) A flag specifying whether the transparency group is a knockout
     * group (see “Knockout Groups”). If this flag is false, later objects within the
     * group shall be composited with earlier ones with which they overlap; if
     * true, they shall be composited with the group’s initial backdrop and shall
     * overwrite (“knock out”) any earlier overlapping objects. Default value:
     * false.
     *
     * @var boolean
     */
    private $k = false;

    public function __construct()
    {
        $this->setType(self::TYPE);
    }

    /**
     * @return Name
     */
    public function getS()
    {
        return $this->s;
    }

    public function setS($s)
    {
        $this->s = Name::by($s);
    }

    /**
     *
     * @return Name|ArrayObject
     */
    public function getCs()
    {
        return $this->cs;
    }

    public function setCs($cs)
    {
        if (!is_string($cs) && !$cs instanceof Name && !$cs instanceof ArrayObject) {
            throw new \InvalidArgumentException('Invalid argument');
        }
        $this->cs = is_string($cs) ? Name::by($cs) : $cs;
    }

    /**
     * @return boolean
     */
    public function getI()
    {
        return $this->i;
    }

    public function setI($i)
    {
        $this->i = $i;
    }

    /**
     * @return boolean
     */
    public function getK()
    {
        return $this->k;
    }

    public function setK($k)
    {
        $this->k = $k;
    }

    protected function getStaticDictionaryFields()
    {
        return array(
            'S',
            'CS',
            'I',
            'K',
        );
    }
}
