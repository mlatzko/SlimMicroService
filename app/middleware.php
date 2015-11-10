<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

// Last In First Out call stack by default by Slim.
$app->add(
    new App\Middleware\StorageAdapterMiddleware(
        $app->getContainer()->get('config'),
        $app->getContainer()->get('registry')
    )
);

$app->add(
    new App\Middleware\ResourceAvailableMiddleware(
        $app->getContainer()->get('config')
    )
);
