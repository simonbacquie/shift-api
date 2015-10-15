<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;

abstract class AuthorizedDomain implements DomainInterface
{

  public function __construct(\ShiftApi\Service\Auth $auth, \ShiftApi\Service\ParamsHelper $paramsHelper) {
    $this->auth = $auth;
    $this->helper = $paramsHelper;
  }

  public function requirePermission($permission) {
    if (!$this->auth->authorizeEndpoint($permission)) {
      return $this->auth->errorPayload;
    }
  }

}
