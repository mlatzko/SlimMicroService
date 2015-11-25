<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

$app->post('/{resource}', '\SlimMicroService\Action\Create:dispatch');

$app->get('/{resource}/{id}', '\SlimMicroService\Action\Read:dispatch');

$app->post('/{resource}/{id}', '\SlimMicroService\Action\Update:dispatch');
$app->patch('/{resource}/{id}', '\SlimMicroService\Action\Update:dispatch');

$app->delete('/{resource}/{id}', '\SlimMicroService\Action\Delete:dispatch');
