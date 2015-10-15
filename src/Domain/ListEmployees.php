<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;
use \ShiftApi\Model\User as User;

class ListEmployees extends AuthorizedDomain
{

  public function __invoke(array $input)
  {
    $this->requirePermission('ListEmployees');

    $employees = User::where(['role' => 'employee'])
      ->get(['id', 'name', 'role', 'email', 'phone', 'created_at', 'updated_at']);

    return (new Payload)
      ->withStatus(Payload::OK)
      ->withOutput(
        $employees->toArray()
      );
  }
}
