#!/usr/bin/env php
<?php

if (!@include __DIR__ . '/../vendor/autoload.php') {
    if (!@include __DIR__ . '/../../../autoload.php') {
        throw new \RuntimeException('Cannot load autoload file');
    }
}

use Jungle\Console\ParseCommand;
use Symfony\Component\Console\Application;

define('APP_ROOT', realpath(__DIR__ . "/../"));

$application = new Application();
$application->add(new ParseCommand());
$application->run();