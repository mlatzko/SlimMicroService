<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */
$app->post('/{resource}', 'App\Action\CreateAction:dispatch');

$app->get('/{resource}/{id}', 'App\Action\ReadAction:dispatch');

$app->patch('/{resource}/{id}', 'App\Action\UpdateAction:dispatch');

$app->delete('/{resource}/{id}', 'App\Action\DeleteAction:dispatch');
