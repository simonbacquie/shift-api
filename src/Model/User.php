<?php
//User Model

namespace ShiftApi\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent {
  protected $table = 'users';

  public function validate() {
    echo "wheeee";
  }
}
