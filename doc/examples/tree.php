<?php

function __autoload($class) {
    require '../../src/' . str_replace('\\', '/', $class) . '.php';
}


$doc = new \Pideph\Document();
$doc->page()
    ->children()
        ->addDivision()
            ->children()
                ->addParagraph()->text('so what?')->end()
                ->addAnchor()->href('http://www.php.net/')->text('php.net')->end()
            ->end()
        ->end()
    ->end();

print_r($doc);