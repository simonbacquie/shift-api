<?php

namespace Spark\Project\Domain;

use Spark\Adr\DomainInterface;
use Spark\Payload;
use \ShiftApi\Model\Shift as Shift;

class UpdateShift extends AuthorizedDomain
{

  public function __invoke(array $input)
  {
    $this->requirePermission('UpdateShift');
    // wow, PHP doesn't automatically parse incoming data if it's a PUT...
    // ideally $input should contain the parsed data
    // leaving this hack here for now
    parse_str(file_get_contents("php://input"), $input);

    $shift = Shift::findOrFail($input['id']);
    $updated_fields = array_merge($shift->toArray(), $input);
    if ($shift->validate($updated_fields)) {
      $shift->fill($updated_fields);
      $shift->save();
    } else {
      return (new Payload)
        ->withStatus(Payload::INVALID) // should be 400
        ->withOutput(
          ['error' => 'Missing required fields.']
        );
    }

    return (new Payload)
      ->withStatus(Payload::OK) // should be 204 with no response
      ->withOutput(
        $shift->toArray()
      );
  }
}
