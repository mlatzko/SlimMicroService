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
// NotFoundHandler changed to return always JSON
// -----------------------------------------------------------------------------
$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        $response     = $container['response'];
        $responseData = array('status' => 'error', 'content' => 'Not found!');

        return $response
            ->withJson($responseData, 404);
    };
};

// -----------------------------------------------------------------------------
// NotAllowedHandler changed to return always JSON
// -----------------------------------------------------------------------------
$container['notAllowedHandler'] = function ($container) {
    return function ($request, $response, $methods) use ($container) {
        $response     = $container['response'];
        $responseData = array(
            'status' => 'error',
            'content' => 'HTTP verb must be one of the following for this route: ' . implode(', ', $methods),
        );

        return $response
            ->withHeader('Allow', implode(', ', $methods))
            ->withJson($responseData, 405);
    };
};
