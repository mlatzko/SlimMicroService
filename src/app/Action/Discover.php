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
 * Behavior of reading a resources.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 1.0.0-RC-1
 */
class Discover extends Action
{
    /**
     * Discover resources.
     */
    public function dispatch($request, $response, $args)
    {
        $params = $request->getQueryParams();

        $filter  = $this->getFilter($params);
        $orderBy = $this->getOrderBy($params);
        $limit   = $this->getLimit($params);
        $offset  = $this->getOffset($params);

        $uris  = $this->adapter->discover($args['resource'], $filter, $orderBy, $limit, $offset);
        $count = $this->adapter->count($filter);

        // set response data
        $responseData = array(
            'status'  => 'ok',
            'content' => $uris,
            'params'  => array(
                'filter'  => $filter,
                'orderBy' => $orderBy,
                'offset'  => $offset,
                'limit'   => $limit,
            ),
            'rows' => $count,
        );

        return $response
            ->withJson($responseData, 200);
    }

    /**
     * Only apply filters on existing fields.
     *
     * @param array $params Request GET parameter.
     *
     * @return array
     */
    private function getFilter(array $params)
    {
        $fieldsNames = $this->adapter->getFieldNames();
        $filter      = array();

        foreach ($fieldsNames as $name) {
            if(TRUE === isset($params[$name])){
                $filter[$name] = $params[$name];
            }
        }

        return $filter;
    }

    /**
     * Get order by.
     *
     * @param array $params Request GET parameter.
     *
     * @return array
     */
    private function getOrderBy(array $params)
    {
        if(TRUE === isset($params['orderBy'])){
            $fieldsNames = $this->adapter->getFieldNames();

            list($fieldName, $direction) = explode('.', $params['orderBy']);

            if(TRUE === in_array($fieldName, $fieldsNames)){
                return array($fieldName => $direction);
            }
        }

        return array();
    }

    /**
     * Get offset.
     *
     * @param array $params Request GET parameter.
     *
     * @return integer
     */
    private function getOffset(array $params)
    {
        if(TRUE === isset($params['offset']) && TRUE === is_numeric($params['offset'])){
            return (integer) $params['offset'];
        }

        return 0;
    }

    /**
     * Get limit.
     *
     * @param array $params Request GET parameter.
     *
     * @return integer
     */
    private function getLimit(array $params)
    {
        if(TRUE === isset($params['limit']) && TRUE === is_numeric($params['limit'])){
            return (integer) $params['limit'];
        }

        return 25;
    }


}
