<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;

class ShowMyShift implements DomainInterface
{

  public function __construct(\ShiftApi\Service\Auth $auth, \ShiftApi\Service\ParamsHelper $paramsHelper) {
    $this->auth = $auth;
    $this->helper = $paramsHelper;

    // MAKE SURE YOU CAN ONLY SEE THIS IF IT'S YOUR SHIFT
  }

  public function __invoke(array $input)
  {
    if (!$this->auth->authorizeEndpoint($input, 'ShowMyShift')) {
      return $this->auth->errorPayload;
    }

    $my_id = $this->auth->User->id;
    $my_shift = \ShiftApi\Model\Shift::where('id', $input['id'])->first();
    $overlapping_shifts = \ShiftApi\Model\Shift::shifts_in_time_range(
      $my_shift->start_time, $my_shift->end_time)->get();
    // $my_shift = $my_shift->get();
    // $overlapping_shifts = $my_shift->with('overlapping_shifts')->get();
    // $overlapping_shifts = 
    // print_r($overlapping_shifts);
    // $my_shifts = $my_shifts->with('manager');
    // $my_shifts = $my_shifts->with('overlapping_shifts');


    return (new Payload)
      ->withStatus(200)
      ->withOutput(
        $overlapping_shifts->toArray()
      );
  }
}
