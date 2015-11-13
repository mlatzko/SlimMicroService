<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */
namespace App\Action;

use Noodlehaus\Config;
use Psr\Log\LoggerInterface;
use App\Registry\RegistryInterface;

/**
 * This class contains the default behaviors required for all
 * action classes.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 0.1 In development.
 */
abstract class AbstractAction
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
     * Contains PSR-3 logger provided by Monolog.
     *
     * @var \Psr\Log\LoggerInterface $logger
     *
     * @link https://github.com/Seldaek/monolog
     */
    protected $logger;

    /**
     * Contains a simple registry implementation.
     *
     * @var \App\Registry\RegistryInterface $registry
     */
    protected $doctrine;

    /**
     * Constructor
     *
     * @param \Noodlehaus\Config              $config
     * @param \Psr\Log\LoggerInterface        $logger
     * @param \App\Registry\RegistryInterface $registry
     */
    public function __construct(Config $config, LoggerInterface $logger, $doctrine)
    {
        $this->logger   = $logger;
        $this->config   = $config;
        $this->doctrine = $doctrine;
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
