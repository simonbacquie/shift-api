<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;

class CreateShift extends AuthorizedDomain
{

  public function __invoke(array $input)
  {
    $this->requirePermission('CreateShift');

    print_r($input);

    // \ShiftApi\Model\Shift

    // $shifts = \ShiftApi\Model\Shift::shiftsInTimeRange($input['start_time'], $input['end_time']);
    // $shifts = $shifts->with('manager')->get();
    // $my_shifts = $my_shifts->with('overlapping_shifts');

    // $shifts = $shifts->get();

    return (new Payload)
      ->withStatus(Payload::OK)
      ->withOutput(
        []
        // $shifts->toArray()
      );
  }
}
