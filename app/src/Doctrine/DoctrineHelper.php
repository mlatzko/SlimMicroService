<?php

namespace App\Doctrine;

class DoctrineHelper
{
    protected $_errors = array();

    const ERROR_REQUIRED = 'required';
    const ERROR_BOUNDARIES = 'boundaries_exceeded';
    const ERROR_TYPE = 'wrong_type';

    protected $_messages = array(
        self::ERROR_REQUIRED => "The field is required.",
        self::ERROR_BOUNDARIES => "The field boundaries are exceeded.",
        self::ERROR_TYPE => "The field data type is wrong.",
    );

    public static function toArray($entityManager, $entity, $args)
    {
        // transform entity into associative array
        $fields = $entityManager->getClassMetadata(get_class($entity))->fieldMappings;
        $record = array(
            'uri' => '/' . $args['resource'] . '/' . $entity->getId(),
        );

        var_dump($fields); exit;

        foreach ($fields as $key => $value) {
            $methodName = 'get' . ucfirst($valuasde['fieldName']);

            $record[$value['fieldName']] = $entity->$methodName();

            if('datetime' === $value['type']) {
                $record[$value['fieldName']] = $entity->$methodName()->format('c');
            }
        }

        unset($record['id']);

        return $record;
    }

    public function getErrorMessageByCode($errorCode)
    {
        return $this->_messages[$errorCode];
    }

    public function validate($entityManager, $entity)
    {
        $fields = $entityManager->getClassMetadata(get_class($entity))->fieldMappings;

        foreach ($fields as $name => $config) {
            $methodName = 'get' . ucfirst($config['fieldName']);

            //var_dump($config, $entity->$methodName());

            if(true === $config['id']) {
                continue;
            }

            if(false === $config['nullable'] && false !== empty($entity->$methodName())) {
                $this->_errors[$config['fieldName']][] = $this->_messages[self::ERROR_REQUIRED];
            }

            if(false === is_null($config['length']) && $config['length'] < strlen($entity->$methodName())) {
                $this->_errors[$config['fieldName']][] = $this->_messages[self::ERROR_BOUNDARIES];
            }

            if('integer' === $config['type'] && is_integer($entity->$methodName())) {
                $this->_errors[$config['fieldName']][] = $this->_messages[self::ERROR_TYPE];
            }
        }

        return $this;
    }

    public function isValid()
    {
        return empty($this->_errors);
    }

    public function getErrors()
    {
        return $this->_errors;
    }
}
