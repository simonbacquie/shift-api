<?php

namespace ShiftApi\Service;

use Spark\Payload;
// use ShiftApi\Exception\AuthException as AuthException;
use ShiftApi\Model\User as User;

class Auth
{

  public $errorPayload;
  public $User;

  const MANAGER_PERMISSIONS = [
    'ListShifts',
    'ListShifts.FilterByDate'
  ]

  public function authorizeEndpoint($input, $required_role = null) {
    if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
      $email = $_SERVER['PHP_AUTH_USER'];
      $provided_password = $_SERVER['PHP_AUTH_PW'];

      $this->User = User::where('email', $email)->first();
      if (!$this->User) {
      // if (is_null($this->User)) {
        $this->errorPayload = self::invalidCredentialsResponse();
        return false;
      }
      // print_r($this->User->password);
      print_r(($provided_password));
      // print_r(sha1($provided_password));
      if ($this->User->password != sha1($provided_password)) {
        $this->errorPayload = self::invalidCredentialsResponse();
        return false;
      }
      if ($required_role && $this->User->role != $required_role) {
        $this->errorPayload = self::unauthorizedEndpointResponse();
        return false;
      }
    } else {
      $this->errorPayload = self::credentialsRequiredResponse();
      return false;
    }
  }

  private function getPermissions() {
    return constant(strtoupper($this->User->role) . '_PERMISSIONS');
  }

  private static function credentialsRequiredResponse() {
    return (new Payload)
      ->withStatus(401)
      ->withOutput([
        'error' => 'Basic auth username & password required to authenticate.',
      ]);
  }

  private static function invalidCredentialsResponse() {
    return (new Payload)
      ->withStatus(401)
      ->withOutput([
        'error' => 'Invalid login credentials.',
      ]);
  }

  private static function unauthorizedEndpointResponse() {
    return (new Payload)
      ->withStatus(403)
      ->withOutput([
        'error' => 'You are not authorized to access this resource',
      ]);
  }
}


