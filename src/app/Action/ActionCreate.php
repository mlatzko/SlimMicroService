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
 * Behavior of creating a resource.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 0.2.0 In production
 */
class ActionCreate extends ActionAbstract
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

        // build validation rules by schema
        $schema = $this->adapter->getSchema();

        $this->parser->setData($schema);
        $this->parser->setIgnore(array('id'));

        $rules = $this->parser->parse();

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

