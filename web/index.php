<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Model/User.php';
require __DIR__ . '/../src/Model/Auth.php';

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Configure the database and boot Eloquent
 */
$capsule = new Capsule;
$capsule->addConnection([
  'driver'    => 'mysql',
  'host'      => 'host',
  'database'  => 'spark-project',
  'username'  => 'homestead',
  'password'  => 'homestead',
  'charset'   => 'utf8',
  'collation' => 'utf8_general_ci',
  'prefix'    => 'prefix_'
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();
// set timezone for timestamps etc
date_default_timezone_set('UTC');

$auth = new \ShiftApi\Service\Auth;

$injector = new \Auryn\Injector;
// $injector->share($capsule);
$injector->share($auth);

// $app = Spark\Application::boot();
$app = Spark\Application::boot($injector);

$app->setMiddleware([
  'Relay\Middleware\ResponseSender',
  'Spark\Handler\ExceptionHandler',
  'Spark\Handler\RouteHandler',
  'Spark\Handler\ActionHandler',
]);

$app->addRoutes(function(Spark\Router $r) {
  $r->get('/hello[/{name}]', 'Spark\Project\Domain\Hello');
});

$app->run();
