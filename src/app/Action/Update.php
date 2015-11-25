<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

namespace SlimMicroService\Action;

use \SlimMicroService\Action;

/**
 * Behavior of updating a resource.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 0.2.0 In production
 */
class Update extends Action
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

        $entity = $this->adapter->read($args['resource'], $args['id']);

        if(NULL === $entity){
            $responseData = array(
                'status'  => 'error',
                'content' => 'Resource not found.'
            );

            return $response
                ->withJson($responseData, 404);
        }

        unset($entity['uri']);

        $requestData = array_merge($entity, $requestData);

        // build validation rules by schema
        $rules = $this->adapter->getValidationRules();

        $this->provider
            ->setData($rules)
            ->populateValidator($this->validator);

        $result = $this->validator->run($requestData);

        if(FALSE === $result->isValid()){
            $responseData = array(
                'status'  => 'error',
                'content' => $result->getErrors(),
            );

            return $response
                ->withJson($responseData, 400);
        }

        $this->adapter->update($args['id'], $requestData);

        return $response
            ->withStatus(204);
    }
}
