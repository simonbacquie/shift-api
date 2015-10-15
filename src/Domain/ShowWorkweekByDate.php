<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;
use \ShiftApi\Model\Shift as Shift;

class ShowWorkweekByDate extends AuthorizedDomain
{

  public function __invoke(array $input)
  {
    if (!$this->auth->authorizeEndpoint('ShowWorkweekByDate')) {
      return $this->auth->errorPayload;
    }

    $my_id = $this->auth->User->id;

    $workweek = Shift::hoursByWeek($input['date'], $my_id);

    return (new Payload)
      ->withStatus(Payload::OK)
      ->withOutput(
        $workweek
      );
  }
}
