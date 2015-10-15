<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;

class ListMyShifts extends AuthorizedDomain
{

  public function __invoke(array $input)
  {
    if (!$this->auth->authorizeEndpoint('ListMyShifts')) {
      return $this->auth->errorPayload;
    }

    $my_id = $this->auth->User->id;
    $my_shifts = \ShiftApi\Model\Shift::where('employee_id', $my_id);
    $my_shifts = $my_shifts->with('manager');
    // $my_shifts = $my_shifts->with('overlapping_shifts');

    if ($this->helper->checkTrue($input, 'unassigned')) {
      $my_shifts = $my_shifts->orWhereNull('employee_id');
    }
    $my_shifts = $my_shifts->get();

    return (new Payload)
      ->withStatus(Payload::OK)
      ->withOutput(
        $my_shifts->toArray()
      );
  }
}
