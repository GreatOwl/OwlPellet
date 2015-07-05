#!/usr/bin/env php
<?php

$root = __DIR__ . '/../';
require_once $root . 'vendor/autoload.php';
require_once $root . 'src/Application/Startup/Bootstrap.php';

use GreatOwl\Application\Startup\Bootstrap;

$cacheDir = $root . 'src/Application/Cache';
$cacheFile = $cacheDir . '/CachedContainer.php';
if (file_exists($cacheFile)) {
    chmod($cacheFile, 0775);
    echo "Cache file was unlocked.\n";
    $openSuccess = chmod($cacheDir, 0775);
    echo "Cache dir was unlocked.\n";
} else {
    $openSuccess = chmod($cacheDir, 0775);
    echo "Cache dir was unlocked.\n";
}

if ($openSuccess) {
    $bootstrap = new BootStrap($root);
    $bootstrap->getDi(true);
    echo "DIC was cached.\n";
} else {
    echo "Could not unlock the Cache.\n";
}

$closeSuccess = chmod($cacheDir, 0755);

if ($closeSuccess) {
    echo "Cache was relocked.\n";
} else {
    echo "Cache could not be relocked.\n";
}