<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

namespace SlimMicroService\Factory;

use \SlimMicroService\Adapter\Doctrine;
use \SlimMicroService\Factory\DoctrineFactory;
use \SlimMicroService\Parser\DoctrineSchemaValidationRules;

/**
 * Provides a adapter to be inject as dependency into a \Action class.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 0.1 In development.
 */
class AdapterFactory
{
    /**
     * Provide an instance of the adapter for doctrine.
     *
     * @param string $type
     * @param \Noodlehaus\ConfigInterface $config Instance of configuration.
     * @param array $args Request arguments.
     *
     * @return \SlimMicroService\Adapter\Interface Instance of slim micros service adapter.
     */
    public static function getAdapter($type, \Noodlehaus\ConfigInterface $config, array $args)
    {
        $methodName = 'get' . ucfirst($type) . 'Adapter';

        return self::$methodName($config, $args);
    }

    /**
     * Provide an instance of the adapter for doctrine.
     *
     * @param \Noodlehaus\ConfigInterface $config Instance of configuration.
     * @param array $args Request arguments.
     *
     * @return \SlimMicroService\Adapter\AdapterDoctrine
     */
    public static function getDoctrineAdapter(\Noodlehaus\ConfigInterface $config, array $args)
    {
        $databaseConfig = $config->get('database');
        $entityManager  = DoctrineFactory::getEntityManager($databaseConfig);

        $parser = new DoctrineSchemaValidationRules;

        $namespace       = $config->get('entitiesConfiguration.namespace');
        $entityClassname = $namespace . $config->get('entities.' . $args['resource'] . '.classname');

        return new Doctrine($entityManager, $entityClassname, $parser);
    }
}
