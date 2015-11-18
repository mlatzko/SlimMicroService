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
 * Action to handle reading a resource
 */
class ActionRead extends ActionAbstract
{
    /**
     * Read resource.
     */
    public function dispatch($request, $response, $args)
    {
        // get entity
        $resource = $this->adapter->read($request);

        if(NULL === $resource){
            $responseData = array('status' => 'error', 'message' => 'Not found');
            return $response->withJson($responseData, 404);
        }

        // set response data
        $responseData = array(
            'status' => 'ok',
            'content' => $resource,
        );

        return $response
            ->withJson($responseData, 200);
    }
}
