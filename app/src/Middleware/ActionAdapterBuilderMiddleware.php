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
 * Providing a adapter to access a storage.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 0.1 In development.
 */
class ActionAdapterBuilderMiddleware extends AbstractMiddleware
{
    /**
     * Register adapter.
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $this->registerAdapter();

        $response = $next($request, $response);

        return $response;
    }

    /**
     * Set adapter on actions.
     */
    private function registerAdapter()
    {
        $actionsSupported = $this->config->get('entitiesConfiguration.actionsSupported');

        foreach ($actionsSupported as $className) {
            if(FALSE === class_exists($className)){
                $this->logger->warning('Action class "' . $className .'" not found.');
                continue;
            }

            $adapter = \SlimMicroService\Factory\FactoryAdapter::build('doctrine');

            $this->container[$className]->setAdapter($adapter);
        }
    }
}
