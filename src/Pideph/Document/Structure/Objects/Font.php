<?php

namespace Pideph\Document\Structure\Objects;

use Pideph\Document\Structure\Objects\Name;

/**
 * Description of Font
 *
 * See Adobe PDF Reference, Edition 2008-7-1
 *   §9.5 Introduction to Font Data Structures
 *
 * @author naitsirch
 */
class Font extends TypedDictionary
{
    const TYPE = 'Font';

    /**
     * (PDF 1.2) A composite font—a font composed of glyphs from a
     * descendant CIDFont (see 9.7, "Composite Fonts")
     */
    const SUBTYPE_TYPE0 = 'Type0';

    /**
     * A font that defines glyph shapes using Type 1 font technology (see
     * 9.6.2, "Type 1 Fonts").
     */
    const SUBTYPE_TYPE1 = 'Type1';

    /**
     * A multiple master font—an extension of the Type 1 font that allows
     * the generation of a wide variety of typeface styles from a single font
     * (see 9.6.2.3, "Multiple Master Fonts")
     */
    const SUBTYPE_MMTYPE1 = 'MMType1';

    /**
     * A font that defines glyphs with streams of PDF graphics operators
     * (see 9.6.5, "Type 3 Fonts")
     */
    const SUBTYPE_TYPE3 = 'Type3';

    /**
     * A font based on the TrueType font format (see 9.6.3, "TrueType Fonts")
     */
    const SUBTYPE_TRUETYPE = 'TrueType';

    /**
     * (PDF 1.2) A CIDFont whose glyph descriptions are based on Type 1
     * font technology (see 9.7.4, "CIDFonts")
     */
    const SUBTYPE_CID_FONT_TYPE0 = 'CIDFontType0';

    /**
     * (PDF 1.2) A CIDFont whose glyph descriptions are based on
     * TrueType font technology (see 9.7.4, "CIDFonts")
     */
    const SUBTYPE_CID_FONT_TYPE2 = 'CIDFontType2';

    const BASEFONT_TIMES_ROMAN = 'Times-Roman';
    const BASEFONT_TIMES_BOLD = 'Times-Bold';
    const BASEFONT_TIMES_ITALIC = 'Times-Italic';
    const BASEFONT_TIMES_BOLD_ITALIC = 'Times-BoldItalic';
    const BASEFONT_HELVETICA = 'Helvetica';
    const BASEFONT_HELVETICA_BOLD = 'Helvetica-Bold';
    const BASEFONT_HELVETICA_OBLIQUE = 'Helvetica-Oblique';
    const BASEFONT_HELVETICA_BOLD_OBLIQUE = 'Helvetica-BoldOblique';
    const BASEFONT_COURIER = 'Courier';
    const BASEFONT_COURIER_BOLD = 'Courier-Bold';
    const BASEFONT_COURIER_OBLIQUE = 'Courier-Oblique';
    const BASEFONT_COURIER_BOLD_OBLIQUE = 'Courier-BoldOblique';
    const BASEFONT_SYMBOL = 'Symbol';
    const BASEFONT_ZAPF_DINGBATS = 'ZapfDingbats';

    const ENCODING_STANDARD = 'StandardEncoding';
    const ENCODING_MAC_ROMAN = 'MacRomanEncoding';
    const ENCODING_MAC_EXPERT = 'MacExpertEncoding';
    const ENCODING_WIN_ANSI = 'WinAnsiEncoding,';

    /**
     * (Required) The type of font; shall be Type1 for a Type 1 font.
     *
     * @var Name
     */
    private $subtype;

    /**
     * (Required) The PostScript name of the font. For Type 1 fonts, this is
     * always the value of the FontName entry in the font program; for more
     * information, see Section 5.2 of the PostScript Language Reference,
     * Third Edition. The PostScript name of the font may be used to find the
     * font program in the conforming reader or its environment. It is also the
     * name that is used when printing to a PostScript output device.
     *
     * @var Name
     */
    private $baseFont;

    /**
     * (Optional) A specification of the font’s character encoding if different
     * from its built-in encoding. The value of Encoding shall be either the
     * name of a predefined encoding (MacRomanEncoding, MacExpertEncoding,
     * or WinAnsiEncoding, as described in Annex D) or an encoding dictionary
     * that shall specify differences from the
     * font’s built-in encoding or from a specified predefined encoding (see
     * 9.6.6, "Character Encoding").
     *
     * @var Name|Encoding
     */
    private $encoding;

    /**
     * (Required in PDF 1.0; optional otherwise) The name by which this font
     * is referenced in the Font subdictionary of the current resource
     * dictionary.
     * This entry is obsolete and should not be used.
     *
     * @deprecated since version 1.1
     * @var Name
     */
    private $name;

    public function __construct()
    {
        $this->setType(self::TYPE);
    }

    /**
     * @return Name
     */
    public function getSubtype()
    {
        return $this->subtype;
    }

    /**
     * See getter
     * 
     * @param Name|string $subtype
     */
    protected function setSubtype($subtype)
    {
        $this->subtype = Name::by($subtype);
    }

    /**
     * @deprecated since version 1.1
     * @return Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * See getter
     *
     * @deprecated since version 1.1
     * @param Name $name
     */
    public function setName($name)
    {
        $this->name = Name::by($name);
    }

    /**
     * @return Name
     */
    public function getBaseFont()
    {
        return $this->baseFont;
    }

    /**
     * See getter
     *
     * @param Name|string $name
     */
    public function setBaseFont($name)
    {
        $this->baseFont = Name::by($name);
    }

    /**
     *
     * @return Name|Encoding
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * See getter
     *
     * @param Name|Encoding $encoding
     */
    public function setEncoding($encoding)
    {
        if (is_string($encoding)) {
            $encoding = Name::by($encoding);
        } else if (!$encoding instanceof Name && !$encoding instanceof Encoding) {
            throw new \InvalidArgumentException('$encoding has to be of type string, Name or Encoding.');
        }
        $this->encoding = $encoding;
    }

    protected function getStaticDictionaryFields()
    {
        return array(
            'Subtype',
            'Name',
            'BaseFont',
            'Encoding',
        );
    }
}
