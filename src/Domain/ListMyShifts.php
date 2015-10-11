<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;

class ListMyShifts implements DomainInterface
{

  public function __construct(\ShiftApi\Service\Auth $auth, \ShiftApi\Service\ParamsHelper $paramsHelper) {
    $this->auth = $auth;
    $this->helper = $paramsHelper;
  }

  public function __invoke(array $input)
  {
    if (!$this->auth->authorizeEndpoint($input, 'ListMyShifts')) {
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
      ->withStatus(200)
      ->withOutput(
        $my_shifts->toArray()
      );
  }
}
