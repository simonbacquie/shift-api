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
    'ShowMyShift',
    'ShowWorkweekByDate'
  ];

  const MANAGER_PERMISSIONS = [
    'ListShifts',
    'ListShifts.FilterByDate',
    'CreateShift',
    'UpdateShift',
    'ListEmployees',
    'ShowEmployee'
  ];

  public function authorizeEndpoint($required_permission) {
    if (isset($_SERVER['PHP_AUTH_USER']) || isset($_SERVER['PHP_AUTH_PW'])) {
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
      ->withStatus(Payload::INVALID) // this should be 401
      ->withOutput([
        'error' => 'Basic auth username & password required to authenticate.',
      ]);
  }

  private static function invalidCredentialsResponse() {
    return (new Payload)
      ->withStatus(Payload::INVALID) // this should be 401
      ->withOutput([
        'error' => 'Invalid login credentials.',
      ]);
  }

  private static function unauthorizedEndpointResponse() {
    return (new Payload)
      ->withStatus(Payload::INVALID) // this should be 403
      ->withOutput([
        'error' => 'You are not authorized to access this resource',
      ]);
  }
}
