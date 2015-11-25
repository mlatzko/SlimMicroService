<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */
require  __DIR__ . '/../vendor/autoload.php';

// see: https://github.com/slimphp/Slim/blob/3.x/Slim/App.php#L319 - always activated
// because required in Middelware classes.
$settings = require  __DIR__ . '/../app/settings.php';

$app = new \Slim\App($settings);

// set up overwrites
require __DIR__ . '/../app/overwrites.php';

// set up dependencies
require __DIR__ . '/../app/dependencies.php';

// register middleware
require __DIR__ . '/../app/middleware.php';

// register routes
require __DIR__ . '/../app/routes.php';

// Run!
$app->run();
