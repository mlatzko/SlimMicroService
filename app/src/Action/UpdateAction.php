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
class UpdateAction extends AbstractAction
{
    /**
     * Update resource.
     */
    public function dispatch($request, $response, $args)
    {
        $requestData = (NULL !== $request->getParsedBody()) ? $request->getParsedBody() : array() ;

        return $response
            ->withStatus(204)
            ->withHeader('Content-Type', 'application/json;charset=utf-8');
    }
}
