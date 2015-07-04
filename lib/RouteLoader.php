<?php
/**
 * Look at my code. Learn from my mistakes. Teach me to improve. We all win.
 * @copyright ©2015
 * @project OwlPellet
 *
 * index.php
 */

namespace GreatOwl\OwlPellet;


use Interop\Container\ContainerInterface;
use Slim\App;
use Slim\Route;

class RouteLoader
{
    private $slim;

    private $container;

    private $routes;

    public function __construct(App $slim, ContainerInterface $container, array $routes = [])
    {
        $this->slim = $slim;
        $this->container = $container;
        $this->routes = $routes;
    }

    public function __invoke()
    {
        foreach ($this->routes as $alias => $parameters) {
            $controller = $this->container->get($this->loadParameter('controller', $parameters));
            $url = $this->loadParameter('route', $parameters);
            $methods = $this->getMethods($parameters);

            $route = $this->slim->map($methods, $url, $controller);

            $this->loadMiddleWare($route, $parameters);

            $route->setName($alias);
        }
    }

    private function getMethods($parameters)
    {
        $methods = $this->loadParameter('methods', $parameters);
        if (!isset($methods)) {
            return ['ANY'];
        }

        $methods = array_map('strtoupper', $methods);

        if ($methods === ['GET']) {
            $methods[] = 'HEAD';
        }

        return $methods;
    }

    private function loadMiddleWare(Route $route, $parameters)
    {
        $middleWare = $this->loadParameter('stack', $parameters);

        if (count($middleWare) > 0) {
            foreach ($middleWare as $key) {
                $route->add($this->container->get($key));
            }
        }

    }

    private function loadParameter($key, array $parameters)
    {
        if (array_key_exists($key, $parameters)) {
            return $parameters[$key];
        }

        return null;
    }
}
