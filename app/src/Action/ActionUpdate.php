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
 * Behavior of updating a resource.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 0.2
 */
class ActionUpdate extends ActionAbstract
{
    /**
     * Read resource.
     */
    public function dispatch($request, $response, $args)
    {
        $requestData = $request->getParsedBody();

        if(NULL === $requestData){
            $responseData = array(
                'status' => 'error',
                'content' => 'No data provided.'
            );

            return $response
                ->withJson($responseData, 400);
        }

        // @todo - add validation

        $this->adapter->update($args['resource'], $args['id'], $requestData);

        return $response
            ->withStatus(204);
    }
}
