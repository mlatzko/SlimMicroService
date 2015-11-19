<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

namespace SlimMicroService\Adapter;

use SlimMicroService\Adapter\AdapterAbstract;

/**
 * Adapter for doctrine.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 0.1 In development.
 */
class AdapterDoctrine
    extends AdapterAbstract
{
    /**
     * Instance of doctrine EntityManager.
     *
     * @var \Doctrine\ORM\EntityManager $entityManager
     */
    protected $entityManager;

    /**
     * Name of the entity class Fully Qualified Structural Element Name (FQSEN).
     *
     * @var string $classname
     */
    protected $classname;

    /**
     * Construct.
     *
     * @param mixed $entityManager Either null or Instance of doctrine EntityManager.
     * @param mixed $classname Either null or a FQSEN string of the entity class.
     */
    public function __construct($entityManager = NULL, $classname = NULL)
    {
        if(NULL !== $entityManager){
            $this->setEntityManger($entityManager);
        }

        if(NULL !== $classname){
            $this->setClassname($classname);
        }
    }

    /**
     * Set entity manager.
     *
     * @param \Doctrine\ORM\EntityManager $entityManager Instance of doctrine EntityManager.
     */
    public function setEntityManger(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Set FQSEN class name of entity.
     *
     * @classname string $classname FQSEN string of the entity class.
     */
    public function setClassname($classname)
    {
        $this->classname = $classname;
    }

    /**
     * Create resource.
     */
    public function create($routeName, array $requestData)
    {
        $entity = new $this->classname;

        foreach ($requestData as $key => $value) {
            $methodName = 'set' . ucfirst($key);

            if(FALSE === method_exists($entity, $methodName)){
                continue;
            }

            $entity->$methodName($value);
        }

        $fields = $this->entityManager->getClassMetadata(get_class($entity))->fieldMappings;

        foreach ($fields as $key => $value) {
            $setMethodName = 'set' . ucfirst($key);
            $getMethodName = 'get' . ucfirst($key);

            if('datetime' === $value['type']){
                $entity->$setMethodName(
                    new \DateTime($entity->$getMethodName())
                );
            }
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return (NULL === $entity) ? array() : $this->entityToArray($routeName, $entity) ;
    }

    /**
     * Read resource.
     */
    public function read($routeName, $identifier)
    {
        $entity = $this->entityManager->find($this->classname, $identifier);

        return (NULL === $entity) ? array() : $this->entityToArray($routeName, $entity) ;
    }

    /**
     * Transform entity into associative array.
     *
     * @param string $routeName
     * @param object $entity
     *
     * @return array
     */
    private function entityToArray($routeName, $entity)
    {
        $fields = $this->entityManager->getClassMetadata(get_class($entity))->fieldMappings;

        $record = array(
            'uri' => '/' . $routeName . '/' . $entity->getId(),
        );

        foreach ($fields as $key => $value) {
            $methodName = 'get' . ucfirst($value['fieldName']);

            $record[$value['fieldName']] = $entity->$methodName();

            if('datetime' === $value['type']) {
                $record[$value['fieldName']] = $entity->$methodName()->format('c');
            }
        }

        unset($record['id']);

        return $record;
    }
}
