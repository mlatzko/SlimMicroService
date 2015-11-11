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
                'uri'       => '/example/' . $args['identifier'],
                'firstname' => 'John',
                'lastname'  => 'Smith',
                'email'     => 'john.smith@example.com',
                'created'   => '2015-11-10T12:00:00Z+00:00',
                'modified'  => '2015-11-10T14:00:00Z+00:00'
            ),
        );

        return $response
            ->withJson($responseData, 200);
    }
}
