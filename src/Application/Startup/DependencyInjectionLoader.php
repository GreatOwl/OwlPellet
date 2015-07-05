<?php
/**
 * Look at my code. Learn from my mistakes. Teach me to improve. We all win.
 * @copyright ©2015
 * @project OwlPellet
 *
 * index.php
 */
namespace GreatOwl\Application\Startup;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Interop\Container\ContainerInterface;

class DependencyInjectionLoader
{
    const FILE_CONFIG = 'config/config.yml';
    const FILE_DI_CACHE = 'cache/DependencyInjection/CachedContainer.php';
    const NAMESPACE_DI_CACHE = 'GreatOwl\Cache\DependencyInjection\CachedContainer';

    protected $approot;
    protected $container;

    public function __construct($appRoot)
    {
        $this->approot = $appRoot;
    }

    protected function buildDi()
    {
        if (!$this->container instanceof ContainerInterface) {
            $root = rtrim($this->approot, '/');
            $container = new ContainerBuilder();
            $fileLocator = new FileLocator($root);
            $yamlLoader = new YamlFileLoader($container, $fileLocator);
            $yamlLoader->load(static::FILE_CONFIG);

            $container->set('symfony.container', $container);
            $container->set('root', $root);
            $container->compile();

            $this->setDi($container->get('container'));
        }
    }

    protected function dumpDi()
    {
        $container = $this->container->get('symfony.container');
        if ($container instanceof ContainerBuilder) {
            $containerCache = static::NAMESPACE_DI_CACHE;
            $exploded = explode('\\', $containerCache);
            $class = array_pop($exploded);
            $namespace = implode('\\', $exploded);

            $phpDumper = new PhpDumper($container);
            $dump = $phpDumper->dump(['class' => $class, 'namespace' => $namespace]);
            if (file_exists($this->approot . static::FILE_DI_CACHE)) {
                chmod($this->approot . static::FILE_DI_CACHE, 0756);
            }
            file_put_contents($this->approot . static::FILE_DI_CACHE, $dump);
        }
    }

    protected function loadDiCache($dumpCache)
    {
        if (!class_exists(static::NAMESPACE_DI_CACHE) || $dumpCache ) {
            $this->buildDi();
            $this->dumpDi();
        } else {
            $containerCache = static::NAMESPACE_DI_CACHE;
            $cachedContainer = new $containerCache;
            $cachedContainer->set('symfony.container', $cachedContainer);

            /** @var ContainerInterface $container */
            $container = $cachedContainer->get('container');
            $this->setDi($container);
        }
    }

    public function getDi($dumpCache = false)
    {
        if ($this->checkEnvironment() || $dumpCache) {
            $this->loadDiCache($dumpCache);
        } else {
            $this->buildDi();
        }

        return $this->container;
    }

    private function checkEnvironment()
    {
        if (isset($_SERVER) && array_key_exists('APP_ENV', $_SERVER)) {
            return $_SERVER['APP_ENV'] !== 'dev';
        } else {
            return false;
        }
    }

    public function setDi(ContainerInterface $container)
    {
        $this->container = $container;
    }
}
