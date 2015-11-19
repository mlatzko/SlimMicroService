<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

namespace SlimMicroService\Middleware;

/**
 * General methods to be used in middle ware classes.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 0.1
 */
class MiddlewareAbstract
{
    /**
     * Contains an object of the lightweight Noodlehaus config class.
     *
     * @var \Noodlehaus\ConfigInterface $config
     *
     * @link https://github.com/hassankhan/config
     */
    protected $config;

    /**
     * Contains an object of the lightweight Noodlehaus config class.
     *
     * @var \Monolog\Logger $logger
     *
     * @link https://github.com/Seldaek/monolog
     */
    protected $logger;

    /**
     * Contains an Slim container.
     *
     * @var \Slim\Container
     */
    protected $container;

    /**
     * Constructor
     *
     * @param \Noodlehaus\ConfigInterface $config
     * @param \Monolog\Logger    $logger
     * @param \Slim\Container    $container
     */
    public function __construct($config = NULL, $logger = NULL, $container = NULL)
    {
        if(NULL !== $config){
            $this->setConfig($config);
        }

        if(NULL !== $logger){
            $this->setLogger($logger);
        }

        if(NULL !== $container){
            $this->setContainer($container);
        }
    }

    /**
     * Set configuration.
     *
     * @param \Noodlehaus\ConfigInterface $config
     */
    public function setConfig(\Noodlehaus\ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * Set logger.
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function setLogger(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Set slim container.
     *
     * @param \Slim\Container $container
     */
    public function setContainer(\Slim\Container $container)
    {
        $this->container = $container;
    }

    /**
     * Get route arguments form request object.
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     *
     * @return array
     */
    protected function getRouteArguments($request)
    {
        $attributes = $request->getAttributes();

        if(FALSE === isset($attributes['route'])){
            return array();
        }

        return $attributes['route']->getArguments();;
    }
}
