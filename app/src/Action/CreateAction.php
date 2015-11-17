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
use App\Doctrine\DoctrineHelper;
use App\Doctrine\Validator\ValidatorSchema;

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
        $namespace       = $this->config->get('entitiesConfiguration.namespace');
        $entityClassName = $namespace . $this->config->get('entities.' . $args['resource'] . '.classname');
        $entityManager   = $this->doctrine;

        if(NULL === $entityClassName){
            $this->logger->critical('Entity class not configured for resource "' . $args['resource'] . '".');
            return $response->withStatus(500);
        }

        $requestData = $request->getParsedBody();

        if(NULL === $requestData){
            $responseData = array('status' => 'error', 'content' => 'No data provided.');
            return $response->withJson($responseData, 400);
        }

        $entity = new $entityClassName;
        $fields = $entityManager->getClassMetadata(get_class($entity))->fieldMappings;


        // Pre-processing fields (remove if possible) but datetime is throwing exceptions.
        foreach ($fields as $key => $value) {
            $methodName = 'set' . ucfirst($value['fieldName']);

            if(FALSE === method_exists($entity, $methodName)){
                continue;
            }

            $entity->$methodName(NULL);
        }

        // processing post data
        foreach ($requestData as $key => $value) {
            $methodName = 'set' . ucfirst($key);

            if(FALSE === method_exists($entity, $methodName)){
                $responseData = array('status' => 'error', 'content' => 'The field "' . $key . '" is supported.');
                return $response->withJson($responseData, 400);
            }

            $entity->$methodName($value);
        }

        $validator = new ValidatorSchema($entityManager, $entity);

        if(FALSE === $validator->isValid()){
            $responseData = array('status' => 'error', 'content' => $validator->getMessages());
            return $response->withJson($responseData, 400);
        }

        exit(__LINE__ . ': ' . __METHOD__);


        $result = $entityManager->persist($entity);
        $entityManager->flush();

        $responseData = array(
            'status'  => 'ok',
            'content' => '/' . $args['resource'] . '/' . $entity->getId(),
        );

        return $response
            ->withJson($responseData, 201);
    }
}
