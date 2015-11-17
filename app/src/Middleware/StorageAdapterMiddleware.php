<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */
namespace App\Middleware;

use Noodlehaus\Config;
use App\Registry\RegistryInterface;

/**
 * Providing a storage adapter to be accessed in a action classes. The correct
 * adapter is determined via configuration file.
 *
 * The file app/config/_config.resources.yml contains a configuration for one
 * or more resource.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 0.1 In development.
 */
class StorageAdapterMiddleware
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
     * Constructor
     *
     * @param \Noodlehaus\Config              $config
     * @param \App\Registry\RegistryInterface $registry
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Determine storage adapter for further use in action classes.
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $response = $next($request, $response);

        return $response;
    }
}
