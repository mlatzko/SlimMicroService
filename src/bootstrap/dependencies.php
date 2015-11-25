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
// Noodlehaus\Config - https://github.com/hassankhan/config
// -----------------------------------------------------------------------------
$container['config'] = function ($c) {
    $config = Noodlehaus\Config::load(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR. 'config');

    return $config;
};

// -----------------------------------------------------------------------------
// Monolog\Logger - https://github.com/Seldaek/monolog
// -----------------------------------------------------------------------------
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

// -----------------------------------------------------------------------------
// \Fuel\Validation\Validator - https://github.com/fuelphp/validation
// -----------------------------------------------------------------------------
$container['validator'] = function ($c) {
    $validator = new \SlimMicroService\Validation\Validator;

    // adding custom rules
    $validator->addCustomRule('SlimMircoServiceDateTime',  '\SlimMicroService\Validation\Rule\DateTime');

    return $validator;
};

// -----------------------------------------------------------------------------
// \Fuel\Validation\Validator - https://github.com/fuelphp/validation
// -----------------------------------------------------------------------------
$container['validator_provider'] = function ($c) {
    $provider = new \Fuel\Validation\RuleProvider\FromArray;

    return $provider;
};
