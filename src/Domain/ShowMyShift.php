<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;

class ShowMyShift extends AuthorizedDomain
{

  // MAKE SURE YOU CAN ONLY SEE THIS IF IT'S YOUR SHIFT

  public function __invoke(array $input)
  {
    $this->requirePermission('ShowMyShift');

    $my_id = $this->auth->User->id;
    $my_shift = \ShiftApi\Model\Shift::where('id', $input['id'])->first();
    $overlapping_shifts = \ShiftApi\Model\Shift::shiftsInTimeRange(
      $my_shift->start_time, $my_shift->end_time);
    $overlapping_shifts = $overlapping_shifts->with('employee')->get();
    // $my_shift = $my_shift->get();
    // $overlapping_shifts = $my_shift->with('overlapping_shifts')->get();
    // $overlapping_shifts = 
    // print_r($overlapping_shifts);
    // $my_shifts = $my_shifts->with('manager');
    // $my_shifts = $my_shifts->with('overlapping_shifts');


    return (new Payload)
      ->withStatus(Payload::OK)
      ->withOutput(
        $overlapping_shifts->toArray()
      );
  }
}
