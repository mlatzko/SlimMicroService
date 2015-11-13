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
        $namespace   = $this->config->get('entitiesConfiguration.namespace');
        $entityClass = $namespace . $this->config->get('entities.' . $args['resource'] . '.classname');

        $resource = $this->doctrine->find($entityClass, $args['id']);

        if(NULL === $resource){
            $responseData = array('status' => 'error', 'message' => 'Not found');
            return $response->withJson($responseData, 404);
        }

        // @todo - add transform optimusprime to have an array instead of entity class object

        $responseData = array(
            'status' => 'ok',
            'content' => array(
                'uri' => '/example/' . $resource->getId(),
                'name' => $resource->getName(),
                'email' => $resource->getEmail(),
                'modified' => $resource->getModified(),
            ),
        );

        return $response
            ->withJson($responseData, 200);
    }
}
