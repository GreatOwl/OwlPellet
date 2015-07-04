<?php
/**
 * Look at my code. Learn from my mistakes. Teach me to improve. We all win.
 * @copyright ©2015
 * @project OwlPellet
 *
 * index.php
 */
namespace Config;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class Bootstrap
{
    const CONFIG_FILE = 'config/config.yml';

    protected $approot;
    protected $cache;
    protected $container;

    public function __construct($appRoot, $cache)
    {
        $this->approot = $appRoot;
        $this->cache = $cache;
    }

    protected function buildDi()
    {
        if (!$this->container instanceof ContainerBuilder) {
            $root = rtrim($this->approot, '/');
            $container = new ContainerBuilder();
            $fileLocator = new FileLocator($root);
            $yamlLoader = new YamlFileLoader($container, $fileLocator);
            $yamlLoader->load(static::CONFIG_FILE);

            $container->set('root', $root);
            $this->container = $container;
        }

        return $this->container;
    }

    protected function loadDi()
    {
        $cacheClass = $this->cache;
        if (!$this->container instanceof $cacheClass) {
            $this->container = new $cacheClass;
        }

        return $this->container;
    }

    public function dumpDi()
    {
        if ($this->container instanceof ContainerBuilder) {
            $cacheClass = $this->cache;
            $exploded = explode('\\', $cacheClass);
            $class = array_pop($exploded);
            $namespace = implode('\\', $exploded);

            $phpDumper = new PhpDumper($this->container);
            return $phpDumper->dump(['class' => $class, 'namespace' => $namespace]);
        }

        return null;
    }

    public function getDi($dev = true)
    {
        if (class_exists($this->cache) && !$dev) {
            $container = $this->loadDi();
        } else {
            $container = $this->buildDi();
        }

        return $container;
    }
}
