<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

namespace SlimMicroService\Factory;

/**
 * Provides a adapter to be inject as dependency into a \Action class.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 0.1 In development.
 */
class FactoryAdapter
{
    /**
     * Provide an instance of the adapter for doctrine.
     *
     * @param string $type
     * @param \Noodlehaus\Config $config Instance of configuration.
     * @param array $args Request arguments.
     *
     * @return \SlimMicroService\Adapter\Interface Instance of slim micros service adapter.
     */
    public static function getAdapter($type, \Noodlehaus\Config $config, array $args)
    {
        $methodName = 'get' . ucfirst($type) . 'Adapter';

        return self::$methodName($config, $args);
    }

    /**
     * Provide an instance of the adapter for doctrine.
     *
     * @param \Noodlehaus\Config $config Instance of configuration.
     * @param array $args Request arguments.
     *
     * @return \SlimMicroService\Adapter\AdapterDoctrine
     */
    public static function getDoctrineAdapter(\Noodlehaus\Config $config, array $args)
    {
        $databaseConfig = $config->get('database');
        $entityManager  = \SlimMicroService\Factory\FactoryDoctrine::getEntityManager($databaseConfig);

        $namespace       = $config->get('entitiesConfiguration.namespace');
        $entityClassname = $namespace . $config->get('entities.' . $args['resource'] . '.classname');

        return new \SlimMicroService\Adapter\AdapterDoctrine($entityManager, $entityClassname);
    }
}
