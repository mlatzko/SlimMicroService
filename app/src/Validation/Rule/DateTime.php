<?php

namespace SlimMicroService\Validation\Rule;

use Fuel\Validation\AbstractRule;

class DateTime extends AbstractRule
{
    /**
     * Contains the rule failure message
     *
     * @var string
     */
    protected $message = 'The field does not contain a valid date.';

    /**
     * @param string $value Value to be validated
     * @param null   $field Unused by this rule
     * @param null   $allFields
     *
     * @return bool
     */
    public function validate($value, $field = NULL, $allFields = NULL)
    {
        $date = \DateTime::createFromFormat(\DateTime::ATOM, $value);

        if($date instanceof \DateTime){
            return TRUE;
        }

        return FALSE;
    }
}
