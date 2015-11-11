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
 * Checking if the resource request is configured in the configuration. If not
 * it is a not supported resource.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 0.1 In development.
 */
class ResourceAvailableMiddleware
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
     * @param \Noodlehaus\Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $resources = $this->config->get('resources');
        $args      = $this->getRouteArguments($request);

        if(FALSE === empty($args)){
            if(TRUE === isset($resources[$args['resource']])){
                $response = $next($request, $response);
                return $response;
            }
        }

        $responseData = array('status' => 'error', 'message' => 'Not found');
        return $response->withJson($responseData, 404);
    }

    /**
     * Get route arguments form request object.
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     *
     * @return array
     */
    private function getRouteArguments($request)
    {
        $args = array();

        $attributes = $request->getAttributes();

        if(TRUE === isset($attributes['route'])){
            $args = $attributes['route']->getArguments();
        }

        return $args;
    }
}
