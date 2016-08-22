<?php

namespace Pideph;

use Pideph\Node\Type\Page;
use Pideph\Generator\Structure;
use Pideph\Generator\Structure\Objects;

/**
 * Pideph\Node\Type\Document
 *
 * @author naitsirch <login.naitsirch@arcor.de>
 */
class Document
{
    private $pages = array();
    private $pagePointer = 0;
    private $version;
    
    public function __construct()
    {
        
    }
    
    public function addPage()
    {
        $this->pages[] = new Page(null, $this, count($this->pages));
        $this->pagePointer = count($this->pages) - 1;
    }
    
    /**
     * Returns the current page.
     * @return Page
     */
    public function page($number = null)
    {
        $count = count($this->pages);
        if (0 == $count) {
            $this->addPage();
            $count++;
        }
        
        if (null === $number) {
            return $this->pages[$this->pagePointer];
        } else if ($number <= 0) {
            throw new \InvalidArgumentException("This document does not have page number $number.");
        } else if ($number > $count) {
            throw new \InvalidArgumentException("This document does not have $number pages.");
        }
        return $this->pages[$number - 1];
    }

    /**
     * Returns all pages.
     * @return Page[]
     */
    public function pages()
    {
        return $this->pages;
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
     * @param \Pideph\Generator\Structure $structure
     * @return \Pideph\Generator\Structure
     */
    public function generate(Structure $structure)
    {
        // document catalog
        $catalog = new Objects\Catalog();
        $catalog->setVersion($this->version());
        $structure->addObject($catalog);

        foreach ($this->pages() as $page) {
            $page->generate($structure);
        }

        $structure->add("%%EOF");

        return $structure;
    }
}
