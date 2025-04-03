<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__ . '/app')
    ->in(__DIR__ . '/bootstrap')
    ->in(__DIR__ . '/config')
    ->in(__DIR__ . '/database')
    ->in(__DIR__ . '/public')
    ->in(__DIR__ . '/routes')
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'native_function_invocation' => true,
    ])
    ->setFinder($finder)
;
