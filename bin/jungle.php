#!/usr/bin/env php
<?php

include __DIR__ . '/../vendor/autoload.php';

use Jungle\Console\ParseCommand;
use Symfony\Component\Console\Application;

define('APP_ROOT', realpath(__DIR__ . "/../"));

$application = new Application();
$application->add(new ParseCommand());
$application->run();