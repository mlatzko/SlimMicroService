<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

namespace SlimMicroService\Action;

use \SlimMicroService\Action;

/**
 * Behavior of deleting a resource.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 1.0.0-RC-1
 */
class Delete extends Action
{
    /**
     * Delete resource.
     */
    public function dispatch($request, $response, $args)
    {
        $entity = $this->adapter->read($args['resource'], $args['id']);

        if(NULL !== $entity){
            $this->adapter->delete($args['id']);
        }

        return $response
            ->withStatus(204);
    }
}
