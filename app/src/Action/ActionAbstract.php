<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

namespace SlimMicroService\Action;

/**
 * A binding of behavior and route to interact with the service.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 0.2.0 In production
 */
abstract class ActionAbstract
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
     * Contains PSR-3 logger provided by Monolog.
     *
     * @var \Psr\Log\LoggerInterface $logger
     *
     * @link https://github.com/Seldaek/monolog
     */
    protected $logger;

    /**
     * Instance of slim micro service adapter.
     *
     * @var \SlimMicroService\Adapter\Interface $adapter
     */
    protected $adapter;

    /**
     * Constructor
     *
     * @param mixed $config Either null of a instance of the config.
     * @param mixed $logger Either null of a instance of the logger.
     * @param mixed $adapter Either null of a instance of the adapter.
     */
    public function __construct($config = NULL, $logger = NULL, $adapter = NULL)
    {
        if(NULL !== $config){
            $this->setConfig($config);
        }

        if(NULL !== $logger){
            $this->setLogger($logger);
        }

        if(NULL !== $adapter){
            $this->setAdapter($adapter);
        }
    }

    /**
     * Set config.
     *
     * @param \Noodlehaus\ConfigInterface $config Instance of \Noodlehaus\ConfigInterface class.
     */
    public function setConfig(\Noodlehaus\ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * Set logger.
     *
     * @param \Noodlehaus\ConfigInterface $logger Instance of an class based on \Psr\Log\LoggerInterface interface.
     */
    public function setLogger(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Set adapter.
     *
     * @param \SlimMicroService\Adapter\AdapterInterface $logger Instance of an class based on \SlimMicroService\Adapter\AdapterInterface interface.
     */
    public function setAdapter(\SlimMicroService\Adapter\AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * This method needs to implemented by all action classes.
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  array                                    $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    abstract public function dispatch($request, $response, $args);
}
