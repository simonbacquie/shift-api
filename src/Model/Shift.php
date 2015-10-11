<?php
//User Model

namespace ShiftApi\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Shift extends Eloquent {
  protected $table = 'shifts';

  public function manager() {
    return $this->belongsTo('ShiftApi\Model\User', 'manager_id', 'id')
      ->select('id', 'name', 'email', 'phone');
  }

  // public function employeesForShift($shift_id) {
  //   return $this->where('id', $shift_id)
  //          
  // }

  // public function coworkers($employee_id) {
  //   return $this->hasMany('ShiftApi\Model\User', 'employee_id', 'id')
  //     ->select('id', 'name', 'email', 'phone')
  //     ->where('', '>=', $this->start_time);
  // }

  // public function overlapping_shifts() {
  //   return $this->where('start_time', '>=', $this->start_time)
  //     ->andWhere('end_time', '<=', $this->end_time);
  // }

  public static function shifts_in_time_range($start_time, $end_time) {
    print_r($start_time);
    print_r($end_time);
    return self::where('start_time', '>=', $start_time)
      ->where('end_time', '<=', $end_time);
  }
}
