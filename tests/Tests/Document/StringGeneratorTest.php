<?php

namespace Pideph\Tests\Document;

use Pideph\Document\Document;
use Pideph\Document\StringGenerator;
use Pideph\Document\Structure\Objects\Page;

/**
 * Pideph\Tests\Document\StringGeneratorTest
 *
 * @author naitsirch
 */
class StringGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testSimpleFile()
    {
        $doc = new Document();
        
        $page = $doc->getCatalog()->getPages()->addPage();
        $page->setMediaBox(array(0, 0, 100, 100));


        $generator = new StringGenerator($doc);
        $generator->generate();

        $content = $generator->getResult();

        return;
    }
}
