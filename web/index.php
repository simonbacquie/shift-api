<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Model/User.php';
require __DIR__ . '/../src/Model/Shift.php';
require __DIR__ . '/../src/Service/Auth.php';
require __DIR__ . '/../src/Service/ParamsHelper.php';
require __DIR__ . '/../src/AuthorizedDomain.php';
// require __DIR__ . '/../src/hacks.php';
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

$paramsHelper = new \ShiftApi\Service\ParamsHelper;
$injector->share($paramsHelper);

$app = Spark\Application::boot($injector);

$app->setMiddleware([
  'Relay\Middleware\ResponseSender',
  'Spark\Handler\ExceptionHandler',
  'Spark\Handler\RouteHandler',
  'Spark\Handler\ActionHandler',
]);

$app->addRoutes(function(Spark\Router $r) {
  $r->get('/shifts',              'Spark\Project\Domain\ListShifts');
  $r->post('/shifts',             'Spark\Project\Domain\CreateShift');
  $r->put('/shifts',              'Spark\Project\Domain\UpdateShift');
  $r->get('/me/shifts',           'Spark\Project\Domain\ListMyShifts');
  $r->get('/me/shifts/{id}',      'Spark\Project\Domain\ShowMyShift');
  $r->get('/employees',           'Spark\Project\Domain\ListEmployees');
  $r->get('/employees/{id}',      'Spark\Project\Domain\ShowEmployee');
  //
  $r->get('/me/workweeks/{date}', 'Spark\Project\Domain\ShowWorkweekByDate');
});

$app->run();
