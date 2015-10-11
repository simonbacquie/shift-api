<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Model/User.php';
require __DIR__ . '/../src/Service/Auth.php';
// require __DIR__ . '/../src/Exception/AuthException.php'; // REMOVE THIS

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Configure the database and boot Eloquent
 */
$capsule = new Capsule;
$capsule->addConnection([
  'driver'    => 'mysql',
  'host'      => 'localhost',
  'database'  => 'spark-project',
  'username'  => 'homestead',
  'password'  => 'secret',
  'charset'   => 'utf8',
  'collation' => 'utf8_general_ci',
  'prefix'    => ''
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();
// set timezone for timestamps etc
date_default_timezone_set('UTC');

$auth = new \ShiftApi\Service\Auth;

$injector = new \Auryn\Injector;
$injector->share($auth);

$app = Spark\Application::boot($injector);

$app->setMiddleware([
  'Relay\Middleware\ResponseSender',
  'Spark\Handler\ExceptionHandler',
  'Spark\Handler\RouteHandler',
  'Spark\Handler\ActionHandler',
]);

$app->addRoutes(function(Spark\Router $r) {
  $r->get('/hello[/{name}]',   'Spark\Project\Domain\Hello');

  // $r->get('/shifts',           'Spark\Project\Domain\ListShifts');
  // $r->get('/shifts/{id}',      'Spark\Project\Domain\ShowShift');
  //
  // $r->get('/workweeks/{date}', 'Spark\Project\Domain\ShowWorkweekByDate');
});

$app->run();
