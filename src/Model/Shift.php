<?php
//User Model

namespace ShiftApi\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Shift extends Eloquent {
  protected $table = 'shifts';

  public function manager() {
    return $this->belongsTo('ShiftApi\Model\User', 'manager_id', 'id');
  }
}
