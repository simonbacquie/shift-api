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
    if (!$this->auth->authorize($input, 'manager')) {
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

    return (new Payload)
      ->withStatus(Payload::OK)
      ->withOutput([
        'hello' => $name,
      ]);
  }
}
