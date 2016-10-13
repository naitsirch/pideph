<?php

namespace Pideph\Document\Structure\Objects;

/**
 * Pideph\Document\Structure\Objects\Catalog
 *
 * @author naitsirch <naitsirch@e.mail.de>
 */
class Catalog extends TypedDictionary
{
    const TYPE = 'Catalog';

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
    private $version = '1.0';

    /**
     * (Required; shall be an indirect reference) The page tree node that
     * shall be the root of the document’s page tree (see 7.7.3, "Page Tree").
     * @var PageTree
     */
    private $pages;

    private $pageMode;

    private $pageLayout;

    private $outlines;

    private $openAction;

    private $names;

    private $acroForm;

    private $viewerPreferences;

    private $structTreeRoot;

    private $metadata;

    public function __construct()
    {
        $this->setType(self::TYPE);

        $this->pages = new PageTree();
    }

    /**
     * Returns the version of the document.
     * @return Name
     */
    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $vp = explode('.', $version);
        if (strlen($version) != 3 || count($vp) != 2 || $vp[0] != 1 || $vp[1] < 0 || $vp[1] > 7) {
            throw new \InvalidArgumentException("The specified version $version is invalid for PDF documents.");
        }

        $this->version = new Name($version);

        return $this;
    }

    /**
     * @return PageTree
     */
    public function getPages()
    {
        return $this->pages;
    }

    public function getPageMode()
    {
        return $this->pageMode;
    }

    public function setPageMode($pageMode)
    {
        $this->pageMode = $pageMode;
    }

    public function getPageLayout()
    {
        return $this->pageLayout;
    }

    public function setPageLayout($pageLayout)
    {
        $this->pageLayout = $pageLayout;
    }

    public function getOutlines()
    {
        return $this->outlines;
    }

    public function setOutlines($outlines)
    {
        $this->outlines = $outlines;
    }

    public function getOpenAction()
    {
        return $this->openAction;
    }

    public function setOpenAction($openAction)
    {
        $this->openAction = $openAction;
    }

    public function getNames()
    {
        return $this->names;
    }

    public function setNames($names)
    {
        $this->names = $names;
    }

    public function getAcroForm()
    {
        return $this->acroForm;
    }

    public function setAcroForm($acroForm)
    {
        $this->acroForm = $acroForm;
    }

    public function getViewerPreferences()
    {
        return $this->viewerPreferences;
    }

    public function setViewerPreferences($viewerPreferences)
    {
        $this->viewerPreferences = $viewerPreferences;
    }

    public function getStructTreeRoot()
    {
        return $this->structTreeRoot;
    }

    public function setStructTreeRoot($structTreeRoot)
    {
        $this->structTreeRoot = $structTreeRoot;
    }

    public function getMetadata()
    {
        return $this->metadata;
    }

    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }

    protected function getStaticDictionaryFields()
    {
        return array(
            'version',
            'pages',
            'pageMode',
            'pageLayout',
            'outlines',
            'openAction',
            'names',
            'acroForm',
            'viewerPreferences',
            'structTreeRoot',
            'metadata',
        );
    }
}
