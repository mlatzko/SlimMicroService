<?php

namespace App\Validator;

use App\Validator\ValidatorInterface;

class ValidatorDefault implements ValidatorInterface
{
    /**
     * @var array $_errors contains a list of errors by field
     */
    protected $messages = array();

    /**
     * @var array $_messages contains a definition list of error messages by types
     */
    protected $messageTemplates = array();

    /**
     * Checks whether messages is empty or not. If not validation is failed.
     *
     * @return boolean
     */
    public function isValid()
    {
        $messages = $this->getMessages();

        if(TRUE === empty($messages)){
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Adding an error message for an field.
     *
     * @param string $fieldName
     * @param string $type
     */
    public function addMessages($fieldName, $identifier)
    {
        if(FALSE === isset($this->messageTemplates[$identifier])) {
            throw new \InvalidArgumentException('The type "' . $type . '" is not defined in the message templates.');
        }

        $this->messages[] = array(
            'fieldName'  => $fieldName,
            'identifier' => $identifier,
            'message'    => $this->messageTemplates[$identifier],
        );
    }

    /**
     * Get messages.
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
