<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;
use \ShiftApi\Model\Shift as Shift;

class ListShifts extends AuthorizedDomain
{

  public function __invoke(array $input)
  {
    if (!$this->auth->authorizeEndpoint('ListShifts')) {
      return $this->auth->errorPayload;
    }

    if (!isset($input['start_time']) || !isset($input['end_time'])) {
      return (new Payload)
        ->withStatus(Payload::INVALID)
        ->withOutput(
          ['error' => 'start_time and end_time fields are required.']
        );
    }

    $shifts = Shift::shiftsInTimeRange($input['start_time'], $input['end_time']);
    $shifts = $shifts->with('manager')->get();

    return (new Payload)
      ->withStatus(Payload::OK)
      ->withOutput(
        $shifts->toArray()
      );
  }
}
