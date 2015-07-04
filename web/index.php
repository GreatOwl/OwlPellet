<?php
/**
 * Look at my code. Learn from my mistakes. Teach me to improve. We all win.
 * @copyright ©2015
 * @project OwlPellet
 *
 * index.php
 */

use Config\Bootstrap;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/Bootstrap.php';

$bootStrap = new Bootstrap(__DIR__ .'/../', 'GreatOwl\OwlPellet\Cache\CachedContainer');
$container = $bootStrap->getDi();

if (!isset($container)) {
    http_response_code(500);
    echo "The application could not load";
    exit;
}

//$slim = $container->get('slim');
$slim = new Slim\App();

$slim->get('/', function () {
    echo 'hi there';
});

$slim->run();
