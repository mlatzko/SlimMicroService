<?php
/**
 * Slim Micro Service
 *
 * @link      https://github.com/mlatzko/SlimMicroService
 * @copyright Copyright (c) 2015 Mathias Latzko
 * @license   https://opensource.org/licenses/MIT
 */

$app->post('/{resource}', '\SlimMicroService\Action\ActionCreate:dispatch');

$app->get('/{resource}/{id}', '\SlimMicroService\Action\ActionRead:dispatch');
