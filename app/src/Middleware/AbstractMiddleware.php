<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

namespace SlimMicroService\Middleware;

class AbstractMiddleware
{
    /**
     * Contains an object of the lightweight Noodlehaus config class.
     *
     * @var \Noodlehaus\Config $config
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
     * @param \Noodlehaus\Config $config
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
     * @param \Noodlehaus\Config $config
     */
    public function setConfig(\Noodlehaus\Config $config)
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
}
