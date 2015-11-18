<?php

namespace SlimMicroService\Factory;

class FactoryDoctrine
{
    public function getAdapter(\Noodlehaus\Config $config, $request)
    {
        exit(__LINE__.' - '.__METHOD__);
    }

    public static function getEntityManager(array $config)
    {
        $doctrineConfig = Setup::createConfiguration(FALSE);
        $driver         = new AnnotationDriver(new AnnotationReader());

        AnnotationRegistry::registerLoader('class_exists');
        $doctrineConfig->setMetadataDriverImpl($driver);

        return EntityManager::create($config, $doctrineConfig);
    }

    public function getEntity($entityName)
    {

    }

    public function getValidator()
    {

    }
}
