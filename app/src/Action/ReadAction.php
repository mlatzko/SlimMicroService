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
 * Action to handle reading a resource
 */
class ReadAction extends AbstractAction
{
    /**
     * Read resource.
     */
    public function dispatch($request, $response, $args)
    {
        $responseData = array(
            'status' => 'ok',
            'content' => array(
                'method'    => $request->getMethod(),
                'arguments' => $args,
            ),
        );

        $this->logger->info('Resource requested.', $args);

        return $response->withJson($responseData, 200);
    }
}