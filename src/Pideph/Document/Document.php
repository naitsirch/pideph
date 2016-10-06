<?php

namespace Pideph\Document;

use Pideph\Node\Type\Page;
use Pideph\Document\Structure;
use Pideph\Document\Structure\Objects;
use Pideph\Document\Structure\Objects\Catalog;

/**
 * Pideph\Node\Type\Document
 *
 * @author naitsirch <naitsirch@e.mail.de>
 */
class Document
{
    private $version;

    /**
     * The document catalog
     * @var Catalog
     */
    private $catalog;
    
    public function __construct()
    {
        $this->catalog = new Catalog();
    }

    /**
     * @return Catalog
     */
    public function getCatalog()
    {
        return $this->catalog;
    }

    /**
     * Set the document's PDF version.
     * @param string $version
     * @return \Pideph\Document
     */
    public function version($version = null)
    {
        if (null === $version) {
            return $this->version;
        }

        $vp = explode('.', $version);
        if (count($vp) != 2 || $vp[0] != 1 || $vp[1] < 0 || $vp[1] > 7) {
            throw new \InvalidArgumentException("The specified version $version is invalid for PDF documents.");
        }
        if (version_compare($this->version, $version) < 0) {
            $this->version = $version;
        }
        return $this;
    }

    /**
     * Generate this document.
     * @return string
     */
    public function generate()
    {
        // print PDF header with some unicode characters, so that this file is
        // regarded as binary
        $content = "%PDF-1.4 %"."\xC6\xA5"."\xC8\x8B"."\xE1\xB8\x8B"."\xD0\xB5"."\xD1\x80"."\xD2\xBB"."\n\n";
        $content .= "%%EOF";

        return $content;
    }
}
