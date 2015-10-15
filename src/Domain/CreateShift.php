<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;
use \ShiftApi\Model\Shift as Shift;

class CreateShift extends AuthorizedDomain
{

  public function __invoke(array $input)
  {
    $this->requirePermission('CreateShift');

    $shift = new Shift();
    if (!isset($input['manager_id'])) {
      // if no manager_id provided, default to the manager creating the shift
      $input['manager_id'] = $this->auth->User->id;
    }
    if ($shift->validate($input)) {
      $shift = new Shift($input);
      $shift->save();
    } else {
      return (new Payload)
        ->withStatus(Payload::INVALID) // should be 400
        ->withOutput(
          ['error' => 'Missing required fields.']
        );
    }

    return (new Payload)
      ->withStatus(Payload::OK) // should be 201
      ->withOutput(
        $shift->toArray()
      );
  }
}
