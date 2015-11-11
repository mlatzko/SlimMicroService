<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */
namespace App\Action;

use App\Action\AbstractAction;

/**
 * Action to handle deleting a resource
 */
class CreateAction extends AbstractAction
{
    /**
     * Create resource.
     */
    public function dispatch($request, $response, $args)
    {
        $responseData = array(
            'status' => 'ok',
            'content' => '/example/AAAAAAAAAAAAAAAAAA',
        );

        $requestData = (NULL !== $request->getParsedBody()) ? $request->getParsedBody() : array() ;

        return $response
            ->withJson($responseData, 201);
    }
}
