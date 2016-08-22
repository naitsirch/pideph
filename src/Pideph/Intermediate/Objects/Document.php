<?php

namespace Pideph\Intermediate\Objects;

/**
 * Pideph\Intermediate\Objects\Document
 *
 * @author naitsirch
 */
class Document extends BaseObject
{
    private $catalog;

    public function __construct()
    {
        $this->catalog = new Catalog($this);
    }

    public function getCatalog()
    {
        return $this->catalog;
    }

    public function getType()
    {
        return '%PDF';
    }
}
