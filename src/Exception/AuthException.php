<?php
namespace ShiftApi\Exception;

class AuthException extends \Exception
{
  public function __construct($message = null, $code = 0, \Exception $previous = null)
  {
    if (!$message) {
      $message = 'Authentication failed.';
    }
    parent::__construct($message, $code, $previous);
  }

  public function getStatusCode()
  {
    return 401;
  }
}
