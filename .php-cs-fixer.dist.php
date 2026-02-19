<?php

$finder = new PhpCsFixer\Finder()
    ->in(__DIR__ . '/src');

return new PhpCsFixer\Config()
    ->setRules([
        '@Symfony' => true,
        'class_attributes_separation' => false,
        'yoda_style' => false,
    ])
    ->setFinder($finder);
