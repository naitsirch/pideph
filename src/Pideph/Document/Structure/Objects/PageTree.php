<?php

namespace Pideph\Document\Structure\Objects;

/**
 * Pideph\Document\Structure\Objects\PageTree
 *
 * @author naitsirch <naitsirch@e.mail.de>
 */
class PageTree extends TypedDictionary
{
    const TYPE = 'Pages';

    /**
     * (Required) An array of indirect references to the immediate children of
     * this node. The children shall only be page objects or other page tree nodes.
     * @var array|PageTree[]|Page[]
     */
    private $kids = array();

    /**
     * (Required) The number of leaf nodes (page objects) that are descendants
     * of this node within the page tree.
     * @var int
     */
    private $count = 0;

    public function __construct()
    {
        $this->setType(self::TYPE);
    }

    /**
     * @return array|PageTree[]|Page[]
     */
    public function getKids()
    {
        return $this->kids;
    }

    /**
     * @return Page
     */
    public function addPage()
    {
        $page = new Page($this);
        $this->kids[] = $page;
        $this->count++;
        return $page;
    }

    /**
     *
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    protected static function getStaticDictionaryFields()
    {
        return array(
            'count',
            'kids',
        );
    }
}
