<?php


$finder = PhpCsFixer\Finder::create()
	->path(['app', 'bootstrap', 'config', 'database', 'routes', 'tests',])
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();
return $config->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder($finder)
;