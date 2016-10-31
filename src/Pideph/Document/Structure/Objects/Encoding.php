<?php

namespace Pideph\Document\Structure\Objects;

use Pideph\Document\Structure\Objects\Name;

/**
 * Description of Font
 *
 * See Adobe PDF Reference, Edition 2008-7-1
 *   §9.6.6 Character Encoding
 *
 * @author naitsirch
 */
class Encoding extends TypedDictionary
{
    const TYPE = 'Encoding';

    const ENCODING_STANDARD = 'StandardEncoding';
    const ENCODING_MAC_ROMAN = 'MacRomanEncoding';
    const ENCODING_MAC_EXPERT = 'MacExpertEncoding';
    const ENCODING_WIN_ANSI = 'WinAnsiEncoding';
    const ENCODING_PDF_DOC = 'PDFDocEncoding';

    /**
     * (Optional) The base encoding—that is, the encoding from which the
     * Differences entry (if present) describes differences— shall be the name
     * of one of the predefined encodings MacRomanEncoding,
     * MacExpertEncoding, or WinAnsiEncoding (see Annex D).
     *
     * If this entry is absent, the Differences entry shall describe differences
     * from an implicit base encoding. For a font program that is embedded in
     * the PDF file, the implicit base encoding shall be the font program’s built-in
     * encoding, as described in 9.6.6, "Character Encoding" and further
     * elaborated in the sub-clauses on specific font types. Otherwise, for a
     * nonsymbolic font, it shall be StandardEncoding, and for a symbolic font,
     * it shall be the font’s built-in encoding.
     *
     * @var Name
     */
    private $baseEncoding;

    /**
     * (Required in PDF 1.0; optional otherwise) The name by which this font
     * is referenced in the Font subdictionary of the current resource
     * dictionary.
     * This entry is obsolete and should not be used.
     *
     * @var \ArrayObject
     */
    private $differences;

    public function __construct()
    {
        $this->setType(self::TYPE);
    }

    /**
     *
     * @return Name
     */
    public function getBaseEncoding()
    {
        return $this->baseEncoding;
    }

    /**
     * See getter
     * 
     * @param Name|string $subtype
     */
    public function setBaseEncoding($subtype)
    {
        $this->baseEncoding = Name::by($subtype);
    }

    /**
     * @return \ArrayObject
     */
    public function getDifferences()
    {
        return $this->differences;
    }

    /**
     * See getter
     *
     * @param \ArrayObject $differences
     */
    public function setDifferences(\ArrayObject $differences)
    {
        $this->differences = $differences;
    }

    protected function getStaticDictionaryFields()
    {
        return array(
            'BaseEncoding',
            'Differences',
        );
    }
}
