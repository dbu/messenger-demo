<?php

$finder = (new PhpCsFixer\Finder())
    ->in('src/')
    ->in('config/')
    ->in('migrations/')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'declare_strict_types' => true,
        'single_line_throw' => false,
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder)
;
