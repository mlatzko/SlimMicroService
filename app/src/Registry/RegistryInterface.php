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
 * To implemented to standardize registry handling.
 *
 * @author <Mathias Latzko> mathias.latzko@gmail.com
 *
 * @version 0.1
 */
interface RegistryInterface
{
    /**
     * Set a new entry.
     *
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value);

    /**
     * Returns a entry value.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * Remove a entry.
     *
     * @param string $key
     */
    public function delete($key);

    /**
     * Lookup if a entry exists
     *
     * @param string $key
     *
     * @return boolean
     */
    public function exists($key);
}
