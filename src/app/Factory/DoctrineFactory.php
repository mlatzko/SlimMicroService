<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

namespace SlimMicroService\Factory;

use \Doctrine\ORM\Tools\Setup;
use \Doctrine\ORM\EntityManager;
use \Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use \Doctrine\Common\Annotations\AnnotationReader;
use \Doctrine\Common\Annotations\AnnotationRegistry;

/**
 * Provides a adapter to be inject as dependency into a \Action class.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 1.0.0-RC-1
 */
class DoctrineFactory
{
    /**
     * Provides a configured instance of the doctrine EnitityManager.
     *
     * @param array $databaseConfig
     *
     * @return Doctrine\ORM\EntityManager Instance of the doctrine EnitityManager.
     */
    public static function getEntityManager(array $databaseConfig)
    {
        $doctrineConfig = Setup::createConfiguration(FALSE);
        $driver         = new AnnotationDriver(new AnnotationReader());

        AnnotationRegistry::registerLoader('class_exists');
        $doctrineConfig->setMetadataDriverImpl($driver);

        return EntityManager::create($databaseConfig, $doctrineConfig);
    }
}
