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
    new SlimMicroService\Middleware\ActionAdapterBuilderMiddleware(
        $app->getContainer()->get('config'),
        $app->getContainer()->get('logger'),
        $app->getContainer()
    )
);

$app->add(
    new SlimMicroService\Middleware\ActionBuilderMiddleware(
        $app->getContainer()->get('config'),
        $app->getContainer()->get('logger'),
        $app->getContainer()
    )
);

$app->add(
    new SlimMicroService\Middleware\ResourceIsSupportedMiddleware(
        $app->getContainer()->get('config'),
        $app->getContainer()->get('logger'),
        $app->getContainer()
    )
);
