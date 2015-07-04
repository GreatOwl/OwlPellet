<?php
/**
 * Look at my code. Learn from my mistakes. Teach me to improve. We all win.
 * @copyright ©2015
 * @project OwlPellet
 *
 * index.php
 */

use Config\Bootstrap;
use GreatOwl\OwlPellet\RouteLoader;
use Slim\App;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/Bootstrap.php';

$bootStrap = new Bootstrap(__DIR__ .'/../', 'GreatOwl\OwlPellet\Cache\CachedContainer');
$container = $bootStrap->getDi();

if (!isset($container)) {
    http_response_code(500);
    echo "The application could not load";
    exit;
}

/** @var RouteLoader $routeLoader */
$routeLoader = $container->get('owl.pellet.route.loader');
$routeLoader();

/** @var App $slim */
$slim = $container->get('slim');
$slim->run();
