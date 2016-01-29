<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

namespace SlimMicroService\Adapter;

use \SlimMicroService\Adapter;

/**
 * Adapter for doctrine.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 1.0.0-RC-1
 */
class Doctrine extends Adapter
{
    /**
     * Instance of doctrine EntityManager.
     *
     * @var \Doctrine\ORM\EntityManager $entityManager
     */
    protected $entityManager;

    /**
     * A doctrine generated entity class.
     *
     * @var object $entity
     */
    protected $entity;

    /**
     * A parser class.
     *
     * @var \SlimMicroService\Parser\DoctrineSchemaValidationRules $parser
     */
    protected $parser;

    /**
     * A serializer class.
     *
     * @var \SlimMicroService\Serializer\DoctrineEntitySerializer $serializer
     */
    protected $serializer;

    /**
     * Construct.
     *
     * @param mixed $entityManager Either null or an entity manager class.
     * @param mixed $entity        Either null or an entity class.
     * @param mixed $parser        Either null or a parser class.
     * @param mixed $serializer    Either null or a serializer class.
     */
    public function __construct($entityManager = NULL, $entity = NULL, $parser = NULL, $serializer)
    {
        if(NULL !== $entityManager){
            $this->setEntityManger($entityManager);
        }

        if(NULL !== $entity){
            $this->setEntity($entity);
        }

        if(NULL !== $parser){
            $this->setParser($parser);
        }

        if(NULL !== $serializer){
            $this->setSerializer($serializer);
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
     * Set entity.
     *
     * @entity object $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * Set parser.
     *
     * @param \SlimMicroService\Parser\DoctrineSchemaValidationRules $parser
     */
    public function setParser(\SlimMicroService\Parser\DoctrineSchemaValidationRules $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Set serializer.
     *
     * @param \SlimMicroService\Serializer\DoctrineEntitySerializer $serializer
     */
    public function setSerializer(\SlimMicroService\Serializer\DoctrineEntitySerializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Create resource.
     */
    public function create($routeName, array $requestData)
    {
        $entity = $this->serializer->toEntity($this->entity, $requestData);

        if(NULL === $entity->getCreated()){
            $entity->markAsCreated();
        }

        if(NULL === $entity->getModified()){
            $entity->markAsUpdated();
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return (NULL === $entity) ? NULL : $this->serializer->toArray($entity, $routeName) ;
    }

    /**
     * Load resources.
     *
     * @param string $routeName
     * @param array $filter
     * @param array $orderBy
     * @param integer $limit
     * @param integer $offset
     *
     * @return array A URI list of resources.
     */
    public function discover($routeName, array $filter, array $orderBy, $limit, $offset)
    {
        $uriList  = array();
        $entities = $this->entityManager
                            ->getRepository(get_class($this->entity))
                            ->findBy($filter, $orderBy, $limit, $offset);

        foreach ($entities as $entity) {
            $uri       = $this->serializer->toURI($entity, $routeName);
            $uriList[] = $uri;
        }

        return $uriList;
    }

    /**
     * Return count of rows.
     *
     * @param array $filter
     *
     * @return integer
     */
    public function count(array $filter)
    {
        $parameterCount   = 0;
        $primaryFieldName = $this->entityManager->getClassMetadata(get_class($this->entity))->getSingleIdentifierFieldName();
        $repository       = $this->entityManager->getRepository(get_class($this->entity));
        $queryBuilder     = $repository->createQueryBuilder('t');

        $queryBuilder->select('COUNT(t.' . $primaryFieldName . ')');

        foreach ($filter as $fieldName => $value) {
            if(0 === $parameterCount){
                $queryBuilder->where('t.'. $fieldName . ' = ?' . $parameterCount);
            } else {
                $queryBuilder->orWhere('t.'. $fieldName . ' = ?' . $parameterCount);
            }

            $queryBuilder->setParameter($parameterCount, $value);
            $parameterCount =+ 1;
        }

        $query = $queryBuilder->getQuery();
        $count = $query->getSingleScalarResult();

        return (integer)$count;
    }

    /**
     * Read resource.
     */
    public function read($routeName, $identifier)
    {
        $entity = $this->entityManager->find(get_class($this->entity), $identifier);

        return (NULL === $entity) ? NULL : $this->serializer->toArray($entity, $routeName) ;
    }

    /**
     * Update resource.
     */
    public function update($identifier, array $requestData)
    {
        $entity = $this->entityManager->find(get_class($this->entity), $identifier);

        $entity = $this->serializer->toEntity($entity, $requestData);

        $entity->markAsUpdated();

        $this->entityManager->merge($entity);
        $this->entityManager->flush();
    }

    /**
     * Delete resource.
     */
    public function delete($identifier)
    {
        $entity = $this->entityManager->find(get_class($this->entity), $identifier);

        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    /**
     * Provide validation rules for \Fule\Validator.
     *
     * @return array
     */
    public function getValidationRules()
    {
        $schema = $this->entityManager->getClassMetadata(get_class($this->entity))->fieldMappings;

        $this->parser->setData($schema);
        $this->parser->setIgnore(array('id'));

        $rules = $this->parser->parse();

        return $rules;
    }

    public function getFieldNames()
    {
        $schema = $this->entityManager->getClassMetadata(get_class($this->entity))->fieldMappings;
        $names  = array();

        foreach ($schema as $value) {
            $names[] = $value['fieldName'];
        }

        return $names;
    }
}
