<?php

namespace App\Doctrine\Validator;

use App\Validator\ValidatorDefault;

class ValidatorSchema extends ValidatorDefault
{
    const ERROR_REQUIRED   = 'required';
    const ERROR_BOUNDARIES = 'boundaries_exceeded';
    const ERROR_TYPE       = 'wrong_type';

    /**
     * @var array $_messages contains a definition list of error messages by types
     */
    protected $_messageTemplates = array(
        self::ERROR_REQUIRED   => "The field is required.",
        self::ERROR_BOUNDARIES => "The field boundaries are exceeded.",
        self::ERROR_TYPE       => "The field data type is wrong.",
    );

    protected $_entityManager;
    protected $_entity;

    public function __construct($entityManager, $entity)
    {
        $this->_entityManager = $entityManager;
        $this->_entity = $entity;
    }

    public function isValid()
    {
        $this->validate();

        return parent::isValid();
    }

    private function validate() {
        $entityManager = $this->_entityManager;
        $entity = $this->_entity;

        $fields = $entityManager->getClassMetadata(get_class($entity))->fieldMappings;

        var_dump($fields); exit;

        foreach ($fields as $key => $value) {
            $fieldName  = $value['fieldName'];
            $methodName = 'get' . ucfirst($fieldName);

            if('id' === $fieldName){
                continue;
            }

            $fieldValue = $entity->$methodName();

            foreach ($value as $identifier) {
                $methodName = 'validate' . ucfirst($identifier);
            }

        }
    }

    private function validateNullable($fieldName, $value)
    {

    }

    private function validateLength($fieldName, $value)
    {
        return TRUE;
    }

    private function validateString($fieldName, $value)
    {
        return TRUE;
    }

    private function validateInteger($fieldName, $value)
    {
        return TRUE;
    }
}
