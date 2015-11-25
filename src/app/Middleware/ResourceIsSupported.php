<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

namespace SlimMicroService\Middleware;

use \SlimMicroService\Middleware;

/**
 * Checking if the resource request is configured in the configuration. If not
 * it is a not supported resource.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 1.0.0-RC-1
 */
class ResourceIsSupported extends Middleware
{
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
        $args = $this->getRouteArguments($request);

        if(FALSE === empty($args)){
            $entity = $this->config->get('entities.' . $args['resource']);

            if(NULL !== $entity){
                $response = $next($request, $response);
                return $response;
            }
        }

        $responseData = array('status' => 'error', 'content' => 'Route not found!');
        return $response->withJson($responseData, 404);
    }
}
