<?php
/**
 * Generate Doctrine entity classes based on existing
 * database tables.
 *
 * @author Mathias Latzko <mathias.latzko@gmail.com>
 *
 * @version 0.1
 *
 * @link http://stackoverflow.com/questions/12754365/doctrine-2-3-entity-generator-samples-docs
 * @link https://gist.github.com/tawfekov/4079388
 */
include '../vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\DatabaseDriver;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Tools\DisconnectedClassMetadataFactory;
use Doctrine\ORM\Tools\EntityGenerator;
use Noodlehaus\Config;
use Monolog\Logger;

### SET UP LOGGER
$logger = new Logger('Doctrine Entity Generator');
$logger->pushHandler(new Monolog\Handler\StreamHandler('php://stdout', Monolog\Logger::DEBUG));

$logger->debug('Logger initialized');

### SET UP CONFIG
$config = Config::load(__DIR__ . DIRECTORY_SEPARATOR . '/../app/config');

$logger->debug('Config initialized');

### SET UP DOCTRINE ENTITY MANAGER
$exportPaths = array(__DIR__ . DIRECTORY_SEPARATOR . 'Entity');

$entityManager = EntityManager::create(
    $config->get('database'),
    Setup::createAnnotationMetadataConfiguration($exportPaths, TRUE)
);

### MAP CUSTOM MYSQL FIELDTYPES
$platform = $entityManager->getConnection()->getDatabasePlatform();
$platform->registerDoctrineTypeMapping('enum', 'string');
$platform->registerDoctrineTypeMapping('bit', 'boolean');

$driver = new DatabaseDriver($entityManager->getConnection()->getSchemaManager());
$driver->setNamespace($config->get('entitiesConfiguration.namespace'));

$entityManager->getConfiguration()->setMetadataDriverImpl($driver);

$logger->debug('EntityManager initialized.');

### SET UP ENTITY GENERATOR
$factory = new DisconnectedClassMetadataFactory();
$factory->setEntityManager($entityManager);

$generator = new EntityGenerator();
$generator->setGenerateAnnotations(true);
$generator->setGenerateStubMethods(true);
$generator->setRegenerateEntityIfExists(true);
$generator->setUpdateEntityIfExists(true);
$generator->setBackupExisting(false);
$generator->setFieldVisibility('protected');

$logger->debug('EntityGenerator initialized.');

### GENERATE ENTITY CLASSES ONLY FOR DEFINED RESOURCES
$entities = $config->get('entities');

foreach ($entities as $key => $entity) {
    $path      = __DIR__ . '/../' . $config->get('entitiesConfiguration.entityPath');
    $filename  = $path . DIRECTORY_SEPARATOR . $config->get('entities.' . $key . '.classname') . '.php';
    $namespace = $config->get('entitiesConfiguration.namespace');
    $classname = $namespace . $config->get('entities.' . $key . '.classname');

    // Generate file content via Doctrine.
    $metadata = $factory->getMetadataFor($classname);
    $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());

    $content  = $generator->generateEntityClass($metadata);

    // Write entity class in to target folder.
    file_put_contents($filename, $content);

    $logger->debug('Entity class "' . $classname .'" generated into folder "' . $path . '.');
}

$logger->info('done');
