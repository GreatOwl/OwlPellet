<?php
namespace GreatOwl\Application\Cache;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InactiveScopeException;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

/**
 * CachedContainer.
 *
 * This class has been auto-generated
 * by the Symfony Dependency Injection Component.
 */
class CachedContainer extends Container
{
    private $parameters;
    private $targetDirs = array();

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->parameters = $this->getDefaultParameters();

        $this->services =
        $this->scopedServices =
        $this->scopeStacks = array();
        $this->scopes = array();
        $this->scopeChildren = array();
        $this->methodMap = array(
            'acclimate.container' => 'getAcclimate_ContainerService',
            'acclimate.symfony.container' => 'getAcclimate_Symfony_ContainerService',
            'container' => 'getContainerService',
            'main' => 'getMainService',
            'owl.pellet.route.loader' => 'getOwl_Pellet_Route_LoaderService',
            'slim' => 'getSlimService',
            'slim.container' => 'getSlim_ContainerService',
        );

        $this->aliases = array();
    }

    /**
     * {@inheritdoc}
     */
    public function compile()
    {
        throw new LogicException('You cannot compile a dumped frozen container.');
    }

    /**
     * Gets the 'acclimate.container' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Acclimate\Container\ContainerAcclimator A Acclimate\Container\ContainerAcclimator instance.
     */
    protected function getAcclimate_ContainerService()
    {
        return $this->services['acclimate.container'] = new \Acclimate\Container\ContainerAcclimator();
    }

    /**
     * Gets the 'acclimate.symfony.container' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Acclimate\Container\ContainerAcclimator A Acclimate\Container\ContainerAcclimator instance.
     */
    protected function getAcclimate_Symfony_ContainerService()
    {
        return $this->services['acclimate.symfony.container'] = $this->get('acclimate.container')->acclimate($this->get('symfony.container'));
    }

    /**
     * Gets the 'container' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Acclimate\Container\CompositeContainer A Acclimate\Container\CompositeContainer instance.
     */
    protected function getContainerService()
    {
        return $this->services['container'] = new \Acclimate\Container\CompositeContainer(array(0 => $this->get('slim.container'), 1 => $this->get('acclimate.symfony.container')));
    }

    /**
     * Gets the 'main' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \GreatOwl\Application\Main A GreatOwl\Application\Main instance.
     */
    protected function getMainService()
    {
        return $this->services['main'] = new \GreatOwl\Application\Main();
    }

    /**
     * Gets the 'owl.pellet.route.loader' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \GreatOwl\Application\Startup\RouteLoader A GreatOwl\Application\Startup\RouteLoader instance.
     */
    protected function getOwl_Pellet_Route_LoaderService()
    {
        return $this->services['owl.pellet.route.loader'] = new \GreatOwl\Application\Startup\RouteLoader($this->get('slim'), $this->get('container'), array('default' => array('route' => '/', 'methods' => array(0 => 'GET'), 'controller' => 'main'), 'andrew' => array('route' => '/{name}', 'methods' => array(0 => 'GET'), 'controller' => 'main')));
    }

    /**
     * Gets the 'slim' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Slim\App A Slim\App instance.
     */
    protected function getSlimService()
    {
        return $this->services['slim'] = new \Slim\App($this->get('container'));
    }

    /**
     * Gets the 'slim.container' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Slim\Container A Slim\Container instance.
     */
    protected function getSlim_ContainerService()
    {
        return $this->services['slim.container'] = new \Slim\Container(array());
    }

    /**
     * {@inheritdoc}
     */
    public function getParameter($name)
    {
        $name = strtolower($name);

        if (!(isset($this->parameters[$name]) || array_key_exists($name, $this->parameters))) {
            throw new InvalidArgumentException(sprintf('The parameter "%s" must be defined.', $name));
        }

        return $this->parameters[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function hasParameter($name)
    {
        $name = strtolower($name);

        return isset($this->parameters[$name]) || array_key_exists($name, $this->parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function setParameter($name, $value)
    {
        throw new LogicException('Impossible to call set() on a frozen ParameterBag.');
    }

    /**
     * {@inheritdoc}
     */
    public function getParameterBag()
    {
        if (null === $this->parameterBag) {
            $this->parameterBag = new FrozenParameterBag($this->parameters);
        }

        return $this->parameterBag;
    }

    /**
     * Gets the default parameters.
     *
     * @return array An array of the default parameters
     */
    protected function getDefaultParameters()
    {
        return array(
            'settings' => array(

            ),
            'routes' => array(
                'default' => array(
                    'route' => '/',
                    'methods' => array(
                        0 => 'GET',
                    ),
                    'controller' => 'main',
                ),
                'andrew' => array(
                    'route' => '/{name}',
                    'methods' => array(
                        0 => 'GET',
                    ),
                    'controller' => 'main',
                ),
            ),
            'debug' => true,
        );
    }
}
