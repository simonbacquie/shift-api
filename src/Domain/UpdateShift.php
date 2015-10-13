<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;

class UpdateShift implements DomainInterface
{

  public function __construct(\ShiftApi\Service\Auth $auth, \ShiftApi\Service\ParamsHelper $paramsHelper) {
    $this->auth = $auth;
    $this->helper = $paramsHelper;
  }

  public function __invoke(array $input)
  {
    if (!$this->auth->authorizeEndpoint($input, 'UpdateShift')) {
      return $this->auth->errorPayload;
    }

    $shifts = \ShiftApi\Model\Shift::shiftsInTimeRange($input['start_time'], $input['end_time']);
    $shifts = $shifts->with('manager')->get();
    // $my_shifts = $my_shifts->with('overlapping_shifts');

    // $shifts = $shifts->get();

    return (new Payload)
      ->withStatus(200)
      ->withOutput(
        $shifts->toArray()
      );
  }
}
