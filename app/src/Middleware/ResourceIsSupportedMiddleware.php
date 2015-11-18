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
 * Checking if the resource request is configured in the configuration. If not
 * it is a not supported resource.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 0.1 In development.
 */
class ResourceIsSupportedMiddleware extends AbstractMiddleware
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

        $responseData = array('status' => 'error', 'content' => 'Not found!');
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
        $attributes = $request->getAttributes();

        if(FALSE === isset($attributes['route'])){
            return array();
        }

        return $attributes['route']->getArguments();;
    }
}
