<?php

namespace Pideph\Document\Structure\Objects\FontTypes;

use Pideph\Document\Structure\Objects\Font;
use Pideph\Document\Structure\Objects\Dictionary;
use Pideph\Document\Structure\Objects\Stream;

/**
 * Pideph\Document\Structure\Objects\FontTypes\Type1Font
 *
 * See Adobe PDF Reference, Edition 2008-7-1
 *   §9.5 Introduction to Font Data Structures
 *   §9.6.2 Type 1 Fonts
 *
 * @author naitsirch
 */
class Type1Font extends Font
{
    public function __construct()
    {
        parent::__construct();
        $this->setSubtype(self::SUBTYPE_TYPE1);
    }

    /**
     * (Required except for the standard 14 fonts) The first character code
     * defined in the font’s Widths array.
     *
     * @return int
     */
    public function getFirstChar()
    {
        return $this->offsetGet('FirstChar');
    }

    /**
     * See getter
     *
     * @param int $firstChar
     */
    public function setFirstChar($firstChar)
    {
        $this->offsetSet('FirstChar', $firstChar);
    }

    /**
     * (Required except for the standard 14 fonts) The first character code
     * defined in the font’s Widths array.
     *
     * @return int
     */
    public function getLastChar()
    {
        return $this->offsetGet('LastChar');
    }

    /**
     * See getter
     *
     * @param int $lastChar
     */
    public function setLastChar($lastChar)
    {
        $this->offsetSet('LastChar', $lastChar);
    }

    /**
     * (Required except for the standard 14 fonts; indirect reference
     * preferred) An array of (LastChar − FirstChar + 1) widths, each
     * element being the glyph width for the character code that equals
     * FirstChar plus the array index. For character codes outside the range
     * FirstChar to LastChar, the value of MissingWidth from the
     * FontDescriptor entry for this font shall be used. The glyph widths
     * shall be measured in units in which 1000 units correspond to 1 unit in
     * text space. These widths shall be consistent with the actual widths
     * given in the font program. For more information on glyph widths and
     * other glyph metrics, see 9.2.4, "Glyph Positioning and Metrics".
     *
     * Beginning with PDF 1.5, the special treatment given to the standard 14
     * fonts is deprecated. Conforming writers should represent all fonts
     * using a complete font descriptor. For backwards capability, conforming
     * readers shall still provide the special treatment identified for the
     * standard 14 fonts.
     *
     * @return \ArrayObject
     */
    public function getWidths()
    {
        return $this->offsetGet('Widths');
    }

    /**
     * See getter
     *
     * @param \ArrayObject $widths
     */
    public function setWidths(\ArrayObject $widths)
    {
        $this->offsetSet('Widths', $widths);
    }

    /**
     * (Required except for the standard 14 fonts; shall be an indirect
     * reference) A font descriptor describing the font’s metrics other than its
     * glyph widths (see 9.8, "Font Descriptors"”\).
     * For the standard 14 fonts, the entries FirstChar, LastChar, Widths,
     * and FontDescriptor shall either all be present or all be absent.
     * Ordinarily, these dictionary keys may be absent; specifying them
     * enables a standard font to be overridden; see 9.6.2.2, "Standard Type
     * 1 Fonts (Standard 14 Fonts)".
     *
     * Beginning with PDF 1.5, the special treatment given to the standard 14
     * fonts is deprecated. Conforming writers should represent all fonts
     * using a complete font descriptor. For backwards capability, conforming
     * readers shall still provide the special treatment identified for the
     * standard 14 fonts.
     *
     * @return Dictionary
     */
    public function getFontDescriptor()
    {
        return $this->offsetGet('FontDescriptor');
    }

    /**
     * See getter
     *
     * @param Dictionary $fontDescriptor
     */
    public function setFontDescriptor(Dictionary $fontDescriptor)
    {
        $this->offsetSet('FontDescriptor', $fontDescriptor);
    }

    /**
     * (Optional; PDF 1.2) A stream containing a CMap file that maps
     * character codes to Unicode values (see 9.10, "Extraction of Text
     * Content").
     *
     * @return Stream
     */
    public function getToUnicode()
    {
        return $this->offsetGet('ToUnicode');
    }

    /**
     * See getter
     *
     * @param Stream $encoding
     */
    public function setToUnicode(Stream $encoding)
    {
        $this->offsetSet('ToUnicode', $encoding);
    }


    protected function getStaticDictionaryFields()
    {
        return parent::getStaticDictionaryFields() + array();
    }
}
