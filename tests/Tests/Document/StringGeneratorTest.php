<?php

namespace Pideph\Tests\Document;

use Pideph\Document\Document;
use Pideph\Document\StringGenerator;
use Pideph\Document\Structure\Objects\Page;
use Pideph\Document\Structure\Objects\Name;
use Pideph\Document\Structure\Objects\FontTypes\Type1Font;
use Pideph\Document\Structure\Objects\Encoding;

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

        $font = new Type1Font();
        $font->setName('F1');
        $font->setBaseFont('Helvetica');
        $font->setEncoding(Encoding::ENCODING_WIN_ANSI);
        
        $page = $doc->getCatalog()->getPages()->addPage();
        $page->setMediaBox(new \ArrayObject(array(0, 0, 900, 900)));
        $page->getResources()->getProcSet()->append(Name::by('PDF'));
        $page->getResources()->getProcSet()->append(Name::by('Text'));
        $page->getResources()->getFont()->add('F1', $font);
        $page->getContents()->addContent(
            'BT ' .
            '/F1 12 Tf ' .
            '288 720 Td ' .
            '(Hallo Welt) Tj ' .
            'ET');


        $generator = new StringGenerator($doc);
        $generator->generate();

        $content = $generator->getResult();

        return;
    }
}
