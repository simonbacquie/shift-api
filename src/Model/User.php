<?php
//User Model

namespace ShiftApi\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent {
  protected $table = 'users';

  public function correctPassword($provided_password) {
    if (sha1($provided_password) == $this->password) {
      return true;
    } else {
      return false;
    }
  }

  public function shifts() {
    return $this->hasMany('ShiftApi\Model\Shift', 'employee_id');
  }
}
