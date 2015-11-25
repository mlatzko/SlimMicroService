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
include '../src/vendor/autoload.php';

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
$config = Config::load(__DIR__ . DIRECTORY_SEPARATOR . '/../src/config');

$logger->debug('Config initialized');

### SET UP STANDARD VARIABLES
$basePath   = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
$entityPath = $config->get('entitiesConfiguration.entityPath');
$pathname   = $basePath . $entityPath;
$pathnames  = array($pathname);
$namespace  = $config->get('entitiesConfiguration.namespace');
$entities   = $config->get('entities');

### CREATE ENTITY FOLDER STRUCTURE
if(FALSE === file_exists($pathname)) {
    $entityPathFolders = explode(DIRECTORY_SEPARATOR, $entityPath);

    $generatorPath = $basePath;

    foreach ($entityPathFolders as $folderName) {
        $generatorPath .= $folderName . DIRECTORY_SEPARATOR;
        if(FALSE === file_exists($generatorPath)){
            $logger->debug('Folder "' . str_replace($basePath, '', $generatorPath) . '" created.');
            mkdir($generatorPath);
        }
    }
}

### SET UP DOCTRINE ENTITY MANAGER
$entityManager = EntityManager::create(
    $config->get('database'),
    Setup::createAnnotationMetadataConfiguration($pathnames, TRUE)
);

### MAP CUSTOM MYSQL FIELDTYPES
$platform = $entityManager->getConnection()->getDatabasePlatform();
$platform->registerDoctrineTypeMapping('enum', 'string');
$platform->registerDoctrineTypeMapping('bit', 'boolean');

$driver = new DatabaseDriver($entityManager->getConnection()->getSchemaManager());
$driver->setNamespace($namespace);

$entityManager->getConfiguration()->setMetadataDriverImpl($driver);

$logger->debug('EntityManager initialized.');

### SET UP ENTITY GENERATOR
$factory = new DisconnectedClassMetadataFactory();
$factory->setEntityManager($entityManager);

$generator = new EntityGenerator();
$generator->setGenerateAnnotations(true);
$generator->setGenerateStubMethods(true);
$generator->setRegenerateEntityIfExists(true);
$generator->setUpdateEntityIfExists(false);
$generator->setBackupExisting(false);
$generator->setFieldVisibility('protected');

$logger->debug('EntityGenerator initialized.');

### GENERATE ENTITY CLASSES ONLY FOR DEFINED RESOURCES
foreach ($entities as $key => $entity) {
    $filename  = $pathname . DIRECTORY_SEPARATOR . $config->get('entities.' . $key . '.classname') . '.php';
    $classname = $namespace . $config->get('entities.' . $key . '.classname');
    $table     = $config->get('entities.' . $key . '.table');
    $extends   = $config->get('entities.' . $key . '.extends');

    // Generate file content via Doctrine.
    $metadata = $factory->getMetadataFor($namespace . ucfirst($table));

    $metadata->table = array('name' => $table);
    $metadata->name  = $classname;
    $metadata->rootEntityName = $classname;

    if(NULL !== $extends){
        $generator->setClassToExtend($extends);
    }

    $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());

    $content = $generator->generateEntityClass($metadata);

    // Write entity class in to target folder.
    file_put_contents($filename, $content);

    $logger->debug('Entity class "' . $classname .'" generated into folder "' . $pathname . '.');
}

$logger->info('done');
