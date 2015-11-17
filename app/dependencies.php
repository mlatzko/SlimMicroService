<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */
$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Overwrite Slim not found and not allowed handler
// -----------------------------------------------------------------------------
$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        $response     = $container['response'];
        $responseData = array('status' => 'error', 'content' => 'Not found');

        return $response->withJson($responseData, 404);
    };
};

$container['notAllowedHandler'] = function ($container) {
    return function ($request, $response, $methods) use ($container) {
        $response     = $container['response'];
        $responseData = array('status' => 'error', 'content' => 'Method must be one of: ' . implode(', ', $methods));

        return $response->withHeader('Allow', implode(', ', $methods))->withJson($responseData, 405);
    };
};

// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------

// Noodlehaus\Config - https://github.com/hassankhan/config
$container['config'] = function ($c) {
    $config = Noodlehaus\Config::load(__DIR__ . DIRECTORY_SEPARATOR . 'config');

    return $config;
};

// Monolog\Logger - https://github.com/Seldaek/monolog
$container['logger'] = function ($c) {
    $config = $c->get('config');
    $name   = $config->get('app.name') . ' ' . '(v' . $config->get('app.version') .')';

    $logger = new Monolog\Logger($name);

    $logger->pushHandler(
        new Monolog\Handler\StreamHandler(
            'php://stdout',
            constant('Monolog\Logger::' . strtoupper($config->get('logger.level')))
        )
    );

    return $logger;
};

$container['doctrine'] = function($container) {
        $config = $container->get('config')->get('database');

        $entityManager = \App\Doctrine\DoctrineBuilder::build($config);

        return $entityManager;
};

// -----------------------------------------------------------------------------
// Action factories
// -----------------------------------------------------------------------------

$container['App\Action\CreateAction'] = function ($c) {
    return new App\Action\CreateAction(
        $c->get('config'),
        $c->get('logger'),
        $c->get('doctrine')
    );
};

$container['App\Action\ReadAction'] = function ($c) {
    return new App\Action\ReadAction(
        $c->get('config'),
        $c->get('logger'),
        $c->get('doctrine')
    );
};

$container['App\Action\UpdateAction'] = function ($c) {
    return new App\Action\UpdateAction(
        $c->get('config'),
        $c->get('logger'),
        $c->get('doctrine')
    );
};

$container['App\Action\DeleteAction'] = function ($c) {
    return new App\Action\DeleteAction(
        $c->get('config'),
        $c->get('logger'),
        $c->get('doctrine')
    );
};
