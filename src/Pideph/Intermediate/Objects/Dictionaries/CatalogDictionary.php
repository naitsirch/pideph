<?php

namespace Pideph\Intermediate\Objects\Dictionaries;

/**
 * Pideph\Intermediate\Objects\Dictionaries\CatalogDictionary
 *
 * @author naitsirch <login.naitsirch@arcor.de>
 */
class CatalogDictionary extends Dictionary
{
    /**
     * (Required; shall be an indirect reference) The page tree node that
     * shall be the root of the document’s page tree (see 7.7.3, "Page Tree").
     *
     * Value: dictionary
     */
    const KEY_PAGES = 'Pages';

    const KEY_METADATA = 'Metadata';

    public function __construct(array $data)
    {
        $data['Type'] = '/Catalog';

        parent::__construct($this->getOptionsResolver()
            ->setDefaults(array(
                self::KEY_PAGES => null,
                self::KEY_METADATA => null,
            ))
            ->resolve($data)
        );
    }

    public function setPages(PagesDictionary $pages)
    {
        $data['Pages'] = $pages;
        return $this;
    }

}
