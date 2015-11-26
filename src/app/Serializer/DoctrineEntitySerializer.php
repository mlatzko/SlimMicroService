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
 * @version 1.0.0-RC-1
 */
class DoctrineEntitySerializer
{
    /**
     * Instance of doctrine EntityManager.
     *
     * @var \Doctrine\ORM\EntityManager $entityManager
     */
    protected $entityManager;

    /**
     * Construct.
     *
     * @param mixed $entityManager Either null or an entity manager class.
     */
    public function __construct($entityManager = NULL)
    {
        if(NULL !== $entityManager){
            $this->setEntityManager($entityManager);
        }
    }

    /**
     * Set entity manager.
     *
     * @param \Doctrine\ORM\EntityManager $entityManager Instance of doctrine entity manager class.
     */
    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Transforms an array into an entity.
     *
     * @param array $data
     * @param object $entity
     *
     * @return object A entity class.
     */
    public function toEntity($entity, array $data)
    {
        $fieldMappings = $this->entityManager->getClassMetadata(get_class($entity))->fieldMappings;

        foreach ($data as $name => $value) {
            $this->setPropertyValue($entity, $name, $value, $fieldMappings[$name]['type']);
        }

        return $entity;
    }

    /**
     * Transforms the data of an entity class into an array.
     *
     * @param object $entity
     *
     * @return array
     */
    public function toArray($entity, $routeName)
    {
        $data        = array();
        $metadata    = $this->entityManager->getClassMetadata(get_class($entity));
        $identifiers = $metadata->identifier;
        $primary     = current($identifiers);
        $fields      = array_keys($metadata->fieldMappings);

        foreach ($fields as $name) {
            if($primary === $name){
                $data['uri'] = '/' . $routeName. '/' . $this->getPropertyValue($entity, $name);
                continue;
            }

            $data[$name] = $this->getPropertyValue($entity, $name);
        }

        return $data;
    }

    /**
     * Set entity property.
     *
     * @param object $entity
     * @param string $name Name of property.
     * @param mixed $value
     * @param string $type
     *
     * @return mixed
     */
    private function setPropertyValue($entity, $name, $value, $type)
    {
        $methodName = 'set' . ucfirst($name);

        if(FALSE === method_exists($entity, $methodName)) {
            throw new \RuntimeException('Method "'.$methodName.'" does not exists on entity class "' . get_class($entity) . '".');
        }

        // We have to assume that the validation catch invalid date formats which are not ISO-8601
        // see: https://github.com/mlatzko/SlimMicroService/blob/master/src/app/Validation/Rule/DateTime.php
        if('datetime' === $type && FALSE === empty($value)){
            $value = \DateTime::createFromFormat(\DateTime::ATOM, $value);
        }

        $entity->$methodName($value);
    }

    /**
     * Get entity property value.
     *
     * @param object $entity
     * @param string $name Name of property.
     *
     * @return mixed
     */
    private function getPropertyValue($entity, $name)
    {
        $methodName = 'get' . ucfirst($name);

        if(FALSE === method_exists($entity, $methodName)) {
            throw new \RuntimeException('Method "'.$methodName.'" does not exists on entity class "' . get_class($entity) . '".');
        }

        $value = $entity->$methodName();

        if($value instanceof \DateTime){
            $value = $value->format(\DateTime::ATOM);
        }

        return $value;
    }
}
