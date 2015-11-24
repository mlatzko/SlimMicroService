<?php

namespace SlimMicroService\Validation;

use \Fuel\Validation\ResultInterface;

class Validator extends \Fuel\Validation\Validator
{
    protected function validateField($field, $data, ResultInterface $result)
    {
        $value = null;

        // If there is data, and the data is not empty and not numeric nor boolean. This allows for strings such as '0' to be passed
        // as valid values.
        $dataPresent = isset($data[$field]) && ! (empty($data[$field]) && ! is_numeric($data[$field]) && ! is_bool($data[$field]));

        if ($dataPresent)
        {
            $value = $data[$field];
        }

        $rules = $this->getFieldRules($field);

        foreach ($rules as $rule)
        {
            if (($dataPresent || $rule->canAlwaysRun()) && ! $rule->validate($value, $field, $data))
            {
                // Don't allow any others to run if this one failed
                $result->setError($field, $this->buildMessage($this->getField($field), $rule), $rule);

                return false;
            }
        }

        // All is good so make sure the field gets added as one of the validated fields
        $result->setValidated($field);

        return true;
    }
}
