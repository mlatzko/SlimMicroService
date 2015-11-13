<?php
namespace App\Doctrine;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class DoctrineBuilder
{

    /**
     * @param array $databaseConfig
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     */
    public static function build(array $databaseConfig)
    {
        $config = Setup::createConfiguration(FALSE);
        $driver = new AnnotationDriver(new AnnotationReader());

        // registering noop annotation autoloader - allow all annotations by default
        AnnotationRegistry::registerLoader('class_exists');
        $config->setMetadataDriverImpl($driver);

        return EntityManager::create($databaseConfig, $config);
    }

}
