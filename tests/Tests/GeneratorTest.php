<?php

namespace Pideph\Tests;

use Pideph\Generator;

/**
 * Pideph\Tests\GeneratorTest
 *
 * @author christian
 */
class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getHtmlFiles
     */
    public function testHtmlLoading($filename)
    {
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );

        $html = file_get_contents($filename);
        $gen = Generator::fromHtml($html);
    }

    public function getHtmlFiles()
    {
        return array(
            array(__DIR__ . '/Resources/Html/simple.html'),
        );
    }
}
