<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

namespace SlimMicroService\Adapter;

/**
 * The adapter interface defined the basic methods a adapter should have so
 * the action classes could work properly.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 0.1 In development.
 */
interface AdapterInterface
{
    /**
     * Create resource.
     *
     * @param string $routeName Name of the route require for URI building.
     * @param array  $requestData Request body data as associated array.
     *
     * @return string URI of the resource.
     */
    public function create($routeName, array $requestData);

    /**
     * Read resource.
     *
     * @param string $routeName Name of the route require for URI building.
     * @param mixed  $identifier Primary identifier of the resource can be string, integer or array.
     *
     * @return array
     */
    public function read($routeName, $identifier);

    /**
     * Update resource.
     *
     * @param string $routeName Name of the route require for URI building.
     * @param mixed  $identifier Primary identifier of the resource can be string, integer or array.
     * @param array  $requestData Request body data as associated array.
     */
    public function update($routeName, $identifier, array $requestData);

    /**
     * Delete resource.
     *
     * @param mixed $identifier Primary identifier of the resource can be string, integer or array.
     */
    public function delete($identifier);
}
