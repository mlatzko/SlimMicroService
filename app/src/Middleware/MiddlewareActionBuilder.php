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
 * Configure action classes.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 0.1 In development.
 */
class MiddlewareActionBuilder extends MiddlewareAbstract
{
    /**
     * Register actions.
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $this->registerActions();

        $response = $next($request, $response);

        return $response;
    }

    /**
     * Register all actions classes supported into the Slim\Container for
     * later usage.
     */
    private function registerActions()
    {
        $actionsSupported = $this->config->get('entitiesConfiguration.actionsSupported');

        foreach ($actionsSupported as $className) {
            if(FALSE === class_exists($className)){
                $this->logger->warning(__METHOD__ . ' - Action class "' . $className .'" not found.');
                continue;
            }

            $class = new $className();

            $class->setConfig($this->container->get('config'));
            $class->setLogger($this->container->get('logger'));
            $class->setValidator($this->container->get('validator'));
            $class->setProvider($this->container->get('validator_provider'));
            $class->setParser($this->container->get('parser'));

            $this->container[$className] = $class;
        }
    }
}
