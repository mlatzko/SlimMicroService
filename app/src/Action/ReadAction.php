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
use App\Doctrine\EntitySerializer;
use App\Doctrine\DoctrineHelper;

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
        $namespace       = $this->config->get('entitiesConfiguration.namespace');
        $entityClassName = $namespace . $this->config->get('entities.' . $args['resource'] . '.classname');
        $entityManager   = $this->doctrine;

        if(NULL === $entityClassName){
            $this->logger->critical('Entity class not configured for resource "' . $args['resource'] . '".');
            return $response->withStatus(500);
        }

        // get entity
        $entity = $entityManager->find($entityClassName, $args['id']);

        if(NULL === $entity){
            $responseData = array('status' => 'error', 'message' => 'Not found');
            return $response->withJson($responseData, 404);
        }

        $record = DoctrineHelper::toArray($entityManager, $entity, $args);

        // set response data
        $responseData = array(
            'status' => 'ok',
            'content' => $record,
        );

        return $response
            ->withJson($responseData, 200);
    }
}
