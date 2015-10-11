<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;

class ListShifts implements DomainInterface
{

  public function __construct(\ShiftApi\Service\Auth $auth) {
    $this->auth = $auth;
  }

  public function __invoke(array $input)
  {
    if (!$this->auth->authorize($input, 'ListShifts')) {
      return $this->auth->errorPayload;
    }

    \ShiftApi\Model\Shift

    return (new Payload)
      ->withStatus(200)
      ->withOutput([
        'hello' => $name,
      ]);
  }
}
