<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

namespace SlimMicroService\Serializer;

/**
 * Contains the transformation handling to either transform an array into an
 * entity and vice versa
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 0.1.0 In development.
 */
class SerializerEntity
{
    /**
     * Instance of doctrine EntityManager.
     *
     * @var \Doctrine\ORM\EntityManager $entityManager
     */
    protected $entityManager;

    /**
     * Instance of entity class.
     *
     * @var object $entity
     */
    protected $entity;

    /**
     * Construct.
     *
     * @param mixed $entityManager Either null or instance of doctrine entity manager class.
     * @param mixed $entity Either null or instance of an entity class.
     */
    public function __construct($entityManager = NULL, $entity = NULL)
    {
        if(NULL !== $entityManager){
            $this->setEntityManager($entityManager);
        }

        if(NULL !== $entity){
            $this->setEntity($entity);
        }
    }

    /**
     * Set entity manager.
     *
     * @param \Doctrine\ORM\EntityManager $entityManager Instance of doctrine entity manager class.
     */
    public function setEntityManger(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Set entity.
     *
     * @param object $entity Instance of a entity class.
     */
    public function setEntity(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entity = $entity;
    }

    /**
     * Transforms an array into an entity.
     *
     * @param array $data
     *
     * @return object A entity class.
     */
    public function toEntity(array $data)
    {

    }

    /**
     * Transforms the data of an entity class into an array.
     *
     * @param object $entity
     *
     * @return array
     */
    public function toArray(object $entity)
    {
        $data = array();

        return $data;
    }
}
