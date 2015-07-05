<?php
/**
 * Look at my code. Learn from my mistakes. Teach me to improve. We all win.
 * @copyright ©2015
 * @project OwlPellet
 *
 * index.php
 */

use GreatOwl\Application\Startup\DependencyInjectionLoader;
use GreatOwl\Application\Startup\RouteLoader;
use Slim\App;

require_once __DIR__ . '/../vendor/autoload.php';

$diLoader = new DependencyInjectionLoader(__DIR__ .'/../');
$container = $diLoader->getDi();

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
