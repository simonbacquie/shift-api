<?php

namespace ShiftApi\Service;

use Spark\Payload;

class Auth
{

  public $errorPayload;

  public function authorize($input, $required_role = null) {
    $this->errorPayload = self::invalidCredentialsResponse();
    return false;
  }

  private static function invalidCredentialsResponse() {

    return (new Payload)
      ->withStatus(Payload::OK)
      ->withOutput([
        'error' => 'Invalid Login',
      ]);
  }

  private static function unauthorizedEndpointResponse() {

    return (new Payload)
      ->withStatus(Payload::OK)
      ->withOutput([
        'error' => 'Invalid Login',
      ]);
  }
}


