<?php

namespace Pideph\Document;

use Pideph\Document\Structure\Objects\Catalog;

/**
 * Pideph\Document\Document
 *
 * @author naitsirch
 */
class Document
{
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
}
