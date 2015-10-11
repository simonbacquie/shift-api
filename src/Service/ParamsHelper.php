<?php

namespace ShiftApi\Service;

class ParamsHelper
{
  const TRUE_VALUES = [1, '1', true, 'true'];

  public function checkTrue($input, $param_index) {
    if (!isset($input[$param_index])) return false;
    if (in_array($input[$param_index], self::TRUE_VALUES)) {
      return true;
    } else {
      return false;
    }
  }

  public function getOrReturnNull($input, $param_index) {
    if (!isset($input[$param_index])) return null;
    return $input[$param_index];
  }
}


