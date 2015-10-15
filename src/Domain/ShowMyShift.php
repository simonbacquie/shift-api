<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;
use \ShiftApi\Model\Shift as Shift;

class ShowMyShift extends AuthorizedDomain
{

  public function __invoke(array $input)
  {
    if (!$this->auth->authorizeEndpoint('ShowMyShift')) {
      return $this->auth->errorPayload;
    }

    $my_id = $this->auth->User->id;
    $my_shift = Shift::where('id', $input['id'])->first();
    if ($my_shift->employee_id != $my_id) {
      return (new Payload)
        ->withStatus(Payload::INVALID) // should be 403, or 404 to be more secure
        ->withOutput(
          $overlapping_shifts->toArray()
        );
    }

    $overlapping_shifts = Shift::shiftsInTimeRange(
      $my_shift->start_time, $my_shift->end_time);
    $overlapping_shifts = $overlapping_shifts->with('employee')->get();

    return (new Payload)
      ->withStatus(Payload::OK)
      ->withOutput(
        ['overlapping_shifts' => $overlapping_shifts->toArray()]
      );
  }
}
