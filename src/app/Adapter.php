<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

namespace SlimMicroService;

/**
 * Default adapter behavior.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 1.0.0-RC-1
 */
abstract class Adapter
{
    /**
     * Create resource.
     *
     * @param string $routeName Name of the route require for URI building.
     * @param array  $requestData Request body data as associated array.
     *
     * @return mixed
     */
    abstract public function create($routeName, array $requestData);

    /**
     * Read resource.
     *
     * @param string $routeName Name of the route require for URI building.
     * @param mixed  $identifier Primary identifier of the resource can be string, integer or array.
     *
     * @return array
     */
    abstract public function read($routeName, $identifier);

    /**
     * Update resource.
     *
     * @param mixed  $identifier Primary identifier of the resource can be string, integer or array.
     * @param array  $requestData Request body data as associated array.
     */
    abstract public function update($identifier, array $requestData);

    /**
     * Delete resource.
     *
     * @param mixed $identifier Primary identifier of the resource can be string, integer or array.
     */
    abstract public function delete($identifier);

    /**
     * Get validation rules.
     *
     * @return array
     */
    abstract public function getValidationRules();
}
