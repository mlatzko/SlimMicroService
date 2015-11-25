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
 * Behavior of creating a resource.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 1.0.0-RC-1
 */
class Create extends Action
{
    /**
     * Read resource.
     */
    public function dispatch($request, $response, $args)
    {
        $requestData = $request->getParsedBody();

        if(NULL === $requestData){
            $responseData = array(
                'status'  => 'error',
                'content' => 'No data provided.'
            );

            return $response
                ->withJson($responseData, 400);
        }

        // validation set up
        $rules = $this->adapter->getValidationRules();

        $this->provider
            ->setData($rules)
            ->populateValidator($this->validator);

        // check for to many fields
        $rulesKeys       = array_keys($rules);
        $requestDataKeys = array_keys($requestData);
        $differences     = array_diff($requestDataKeys, $rulesKeys);

        if(FALSE === empty($differences)){
            $responseData = array(
                'status'  => 'error',
                'content' => 'The field/s are not supported: ' . implode(',', $differences)
            );

            return $response
                ->withJson($responseData, 400);
        }

        // run validation
        $result = $this->validator->run($requestData);

        if(FALSE === $result->isValid()){
            $responseData = array(
                'status'  => 'error',
                'content' => $result->getErrors(),
            );

            return $response
                ->withJson($responseData, 400);
        }

        $resource = $this->adapter->create($args['resource'], $requestData);

        // set response data
        $responseData = array(
            'status'  => 'ok',
            'content' => $resource['uri'],
        );

        return $response
            ->withJson($responseData, 201);
    }
}

