<?php

namespace Pideph\Tests\File;

use Pideph\Document\Document;
use Pideph\Document\Structure\Objects\Page;

/**
 * Pideph\Tests\File\FileTest
 *
 * @author naitsirch
 */
class FileTest extends \PHPUnit_Framework_TestCase
{
    public function testSimpleFile()
    {
        $doc = new Document();
        
        $page = $doc->getCatalog()->getPages()->addPage();
        $page->setMediaBox(array(0, 0, 100, 100));


        $doc->generate();
    }
}
