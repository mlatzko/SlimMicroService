<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

namespace SlimMicroService\Adapter;

use SlimMicroService\Adapter\AdapterInterface;

/**
 * Default adapter behavior.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 0.1 In development.
 */
abstract class AdapterAbstract
    implements AdapterInterface
{
    /**
     * Create resource.
     */
    public function create($routeName, array $requestData){
        throw new \RuntimeException('Method create not implement on adapter.');
    }

    /**
     * Read resource.
     */
    public function read($routeName, $identifier){
        throw new \RuntimeException('Method create not implement on adapter.');
    }

    /**
     * Update resource.
     */
    public function update($routeName, $identifier, array $requestData){
        throw new \RuntimeException('Method create not implement on adapter.');
    }

    /**
     * Delete resource.
     */
    public function delete($identifier){
        throw new \RuntimeException('Method create not implement on adapter.');
    }
}
