<?php
/**
 * Look at my code. Learn from my mistakes. Teach me to improve. We all win.
 * @copyright ©2015
 * @project OwlPellet
 *
 * index.php
 */

use GreatOwl\Furcula\Loaders\DependencyInjection;
use GreatOwl\Furcula\Loaders\Routing;
use Slim\App;

require_once __DIR__ . '/../vendor/autoload.php';

$diLoader = new DependencyInjection(__DIR__ .'/../');
$container = $diLoader->getDi();

if (!isset($container)) {
    http_response_code(500);
    echo "The application could not load";
    exit;
}

/** @var Routing $routing */
$routing = $container->get('furcula.loader.routing');
$routing();

/** @var App $slim */
$slim = $container->get('slim');
$slim->run();
