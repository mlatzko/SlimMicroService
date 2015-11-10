<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */
$app->post('/{resource}', 'App\Action\CreateAction:dispatch');

$app->get('/{resource}/{identifier}', 'App\Action\ReadAction:dispatch');

$app->patch('/{resource}/{identifier}', 'App\Action\UpdateAction:dispatch');

$app->delete('/{resource}/{identifier}', 'App\Action\DeleteAction:dispatch');
