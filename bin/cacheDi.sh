#!/usr/bin/env php
<?php

$root = __DIR__ . '/../';
require_once $root . 'vendor/autoload.php';
require_once $root . 'src/Application/Startup/DependencyInjectionLoader.php';

use GreatOwl\Application\Startup\DependencyInjectionLoader;

$diLoader = new DependencyInjectionLoader($root);
$diLoader->getDi(true);
echo "DIC was cached.\n";
