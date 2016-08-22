<?php

namespace Pideph\Intermediate\Objects;

/**
 * Pideph\Intermediate\Objects\Catalog
 *
 * @author naitsirch <login.naitsirch@arcor.de>
 */
class Catalog extends BaseObject
{
    /**
     * (Optional; PDF 1.4) The version of the PDF specification to which the
     * document conforms (for example, 1.4) if later than the version specified
     * in the file’s header (see 7.5.2, "File Header"). If the header
     * specifies a later version, or if this entry is absent, the document shall
     * conform to the version specified in the header. This entry enables a
     * conforming writer to update the version using an incremental update; see
     * 7.5.6, "Incremental Updates."
     * The value of this entry shall be a name object, not a number, and
     * therefore shall be preceded by a SOLIDUS (2Fh) character (/) when written
     * in the PDF file (for example, /1.4).
     * @PDFType name
     * @var string PDF Version [1.0 - 1.7]
     */
    protected $version = '1.0';

    /**
     * (Required; shall be an indirect reference) The page tree node that
     * shall be the root of the document’s page tree (see 7.7.3, "Page Tree").
     * @PDFType dictionary
     * @var \Pideph\Generator\Structure\Objects\Pages
     */
    protected $pages;

    public function __construct(Document $document)
    {
        $this->parent = $document;
        $this->pages = new Pages($this);
    }

    public function getType()
    {
        return 'Catalog';
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $vp = explode('.', $version);
        if (count($vp) != 2 || $vp[0] != 1 || $vp[1] < 0 || $vp[1] > 7) {
            throw new \InvalidArgumentException("The specified version $version is invalid for PDF documents.");
        }

        $this->version = $version;

        return $this;
    }

    public function getPages()
    {
        return $this->pages;
    }

    public function setPages(Pages $pageTree)
    {
        $this->pages = $pageTree;
    }
}
