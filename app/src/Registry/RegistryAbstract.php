<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */
namespace App\Registry;

/**
 * This class provides a basic registry handling to be further used
 * in concrete implementations.
 *
 * @author <Mathias Latzko> mathias.latzko@gmail.com
 *
 * @version 0.1
 */
abstract class RegistryAbstract
    implements RegistryInterface
{
    /**
     * Contains registry entries.
     *
     * @var array $registryList
     */
    protected $registryList = array();

    /**
     * Set a new entry.
     *
     * @param string $key
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     */
    public function set($key, $value)
    {
        $this->validateKey($key);

        if(NULL === $value){
            throw new \InvalidArgumentException('Null is a not allowed value.');
        }

        $this->registryList[$key] = $value;

        return NULL;
    }

    /**
     * Returns a entry value.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        $this->validateKey($key);

        if(TRUE === $this->exists($key)){
            return $this->registryList[$key];
        }

        return NULL;
    }

    /**
     * Remove a entry.
     *
     * @param string $key
     */
    public function delete($key)
    {
        $this->validateKey($key);

        if(TRUE === $this->exists($key)){
            unset($this->registryList[$key]);
        }
    }

    /**
     * Lookup if a entry exists
     *
     * @param string $key
     *
     * @return boolean
     */
    public function exists($key)
    {
        $this->validateKey($key);

        return isset($this->registryList[$key]);
    }

    /**
     * Validate key content.
     *
     * @param string $string
     *
     * @throws InvalidArgumentException
     */
    private function validateKey($string)
    {
        if(FALSE === is_string($string) || TRUE === empty($string)){
            throw new \InvalidArgumentException('Only a not empty string are allowed as key.');
        }
    }
}
