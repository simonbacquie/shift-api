<?php

namespace ShiftApi\Service;

use Spark\Payload;
// use ShiftApi\Exception\AuthException as AuthException;
use ShiftApi\Model\User as User;

class Auth
{

  public $errorPayload;
  public $User;

  const EMPLOYEE_PERMISSIONS = [
    'ListMyShifts',
    'ListShifts.FilterByDate',
    'ShowMyShift'
  ];

  const MANAGER_PERMISSIONS = [
    'ListShifts',
    'ListShifts.FilterByDate',
    'CreateShift',
    'UpdateShift',
    'ListEmployees',
    'ShowEmployee'
  ];

  public function authorizeEndpoint($input, $required_permission = null) {
    if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
      $email = $_SERVER['PHP_AUTH_USER'];
      $provided_password = $_SERVER['PHP_AUTH_PW'];

      $this->User = User::where('email', $email)->first();
      if (!$this->User) {
        $this->errorPayload = self::invalidCredentialsResponse();
        return false;
      }
      if (!$this->User->correctPassword($provided_password)) {
        $this->errorPayload = self::invalidCredentialsResponse();
        return false;
      }
      if ($required_permission && !$this->hasPermission($required_permission)) {
        $this->errorPayload = self::unauthorizedEndpointResponse();
        return false;
      }
    } else {
      $this->errorPayload = self::credentialsRequiredResponse();
      return false;
    }
    return true;
  }

  public function hasPermission($permission) {
    return in_array($permission, $this->getPermissions());
  }

  private function getPermissions() {
    return constant('self::' . strtoupper($this->User->role) . '_PERMISSIONS');
  }

  private static function credentialsRequiredResponse() {
    return (new Payload)
      ->withStatus(Payload::INVALID)
      ->withOutput([
        'error' => 'Basic auth username & password required to authenticate.',
      ]);
  }

  private static function invalidCredentialsResponse() {
    return (new Payload)
      ->withStatus(Payload::INVALID)
      ->withOutput([
        'error' => 'Invalid login credentials.',
      ]);
  }

  private static function unauthorizedEndpointResponse() {
    return (new Payload)
      ->withStatus(Payload::INVALID)
      ->withOutput([
        'error' => 'You are not authorized to access this resource',
      ]);
  }
}
