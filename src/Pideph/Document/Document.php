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
}
