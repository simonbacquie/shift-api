<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;
// use Illuminate\Database\Capsule\Manager as Capsule;

class Hello implements DomainInterface
{

  public function __construct(\ShiftApi\Service\Auth $auth) {
    $this->auth = $auth;
  }

  public function __invoke(array $input)
  {
    if (!$this->auth->authorizeEndpoint($input, 'ListShifts')) {
      return $this->auth->errorPayload;
    }
    // if (\Auth::validateLogin($input, 'manager')) {
    // return \Auth::invalidCredentialsResponse();
    // }

    $u = new \ShiftApi\Model\User();
    $name = 'world';

    if (!empty($input['name'])) {
      $name = $input['name'];
    }

    // die();

    return (new Payload)
      ->withStatus(200)
      ->withOutput([
        'hello' => $name,
      ]);
  }
}
