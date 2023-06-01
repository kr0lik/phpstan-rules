<?php

$config = new kr0lik\CodeStyleFixer\Config;
$config->getFinder()->in(__DIR__.'/src');
$config->getFinder()->in(__DIR__.'/tests');
$config->setCacheFile(__DIR__ . '/.php_cs.cache');

return $config;
