<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;
use \ShiftApi\Model\Shift as User;

class ShowEmployee extends AuthorizedDomain
{

  public function __invoke(array $input)
  {
    if (!$this->auth->authorizeEndpoint('ShowEmployee')) {
      return $this->auth->errorPayload;
    }

    $user = User::find($input['id']);

    return (new Payload)
      ->withStatus(Payload::OK)
      ->withOutput(
        $user->toArray()
      );
  }
}
