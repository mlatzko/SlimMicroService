<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

namespace SlimMicroService\Parser;

/**
 * Parsing doctrine schema to transform it into an array the Fuel validation
 * needs to validate properly.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 1.0.0 RC-1
 */
class DoctrineSchemaValidationRules
{
    /**
     * @var array $schemaData Contains an array based on doctrine schema.
     */
    protected $data;

    /**
     * @var array $rules Contains validation rules for Fuel\Validator.
     */
    protected $rules;

    /**
     * @var array $ignore Contains a list of fields to ignore while parsing.
     */
    protected $ignore;

    protected $primitiveTypes = array('string', 'text', 'integer', 'boolean');

    public function __construct($data = NULL, $ignore = NULL)
    {
        if(NULL !== $data){
            $this->setData($data);
        }

        if(NULL !== $ignore){
            $this->setIgnore($ignore);
        }
    }

    /**
     * Set data.
     *
     * @param array $data A schema array from doctrine.
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * Set field to ignore.
     *
     * @param array $ignore A list of fields to ignore while parsing.
     */
    public function setIgnore(array $ignore)
    {
        $this->ignore = $ignore;
    }

    /**
     * Parse schema data.
     *
     * @return array A list of validation rules for Fuel\Validator.
     *
     * @throws RuntimeException In case no suitable parser method is found.
     */
    public function parse()
    {
        foreach ($this->data as $schema) {
            $name = $schema['fieldName'];
            $type = $schema['type'];

            if(TRUE === in_array($name, $this->ignore)){
                continue;
            }

            if(TRUE === in_array($type, $this->primitiveTypes)){
                $this->parsePrimitivesTypes($schema);
                continue;
            }

            $methodName = 'parse' . ucfirst($type);

            if(FALSE === method_exists($this, $methodName)){
                throw new \RuntimeException('No parser method implemented for type "' . $type . '".');
            }

            $this->$methodName($schema); // parse non primitive types
        }

        return $this->getRules();
    }

    /**
     * Add rule.
     *
     * @param string $name Name of the field.
     * @param string $key Name of the rule with the rule.
     * @param mixed $value Value of the for the rule
     */
    private function addRule($name, $key, $value = NULL)
    {
        if(FALSE === isset($this->rules[$name])){
            $this->rules[$name] = array();
        }

        // Because of Fuel\Validator using two signatures we
        // need to differentiate here. Me mad Bro?
        if(NULL !== $value){
            $this->rules[$name][$key] = $value;
            return;
        }

        // add simple rules like 'required' or custom rules without parameters.
        $this->rules[$name][] = $key;
    }

    private function getRules()
    {
        return $this->rules;
    }

    /**
     * Parse primitive types of fields.
     *
     * @param array $schema Doctrine field schema.
     */
    private function parsePrimitivesTypes(array $schema)
    {
        $name = $schema['fieldName'];
        $type = $schema['type'];

        if(FALSE === $schema['nullable']){
            $this->addRule($name, 'required');
        }

        if(NULL !== $schema['length']){
            $this->addRule($name, 'maxLength', array($schema['length']));
        }

        // replace some types to fit type rule
        // @link \Fule\Validation\Rule\Type
        $search  = array('text', 'boolean');
        $replace = array('string', 'bool');
        $type    = str_replace($search, $replace, $type);

        $this->addRule($name, 'type', array($type));
    }

    /**
     * Parse date time fields.
     *
     * @param array $schema Doctrine field schema.
     */
    private function parseDatetime(array $schema)
    {
        $name = $schema['fieldName'];

        if(FALSE === $schema['nullable']){
            $this->addRule($name, 'required');
        }

        $this->addRule($name, 'SlimMircoServiceDateTime');
    }
}
