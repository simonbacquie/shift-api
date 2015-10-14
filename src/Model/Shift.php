<?php
//User Model

namespace ShiftApi\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Validation\Factory as ValidatorFactory;
use Symfony\Component\Translation\Translator;

class Shift extends Eloquent {
  protected $table          = 'shifts';
  protected $guarded        = ['id']; // don't accept id in mass assignment, must auto-increment
  private $validation_rules = [
    'start_time' => 'required',
    'end_time'   => 'required'
  ];

  public function validate($data) {
    $factory = new ValidatorFactory(new Translator('en'));
    $v = $factory->make($data, $this->validation_rules);

    return $v->passes();
  }

  public function manager() {
    return $this->belongsTo('ShiftApi\Model\User', 'manager_id', 'id')
      ->select('id', 'name', 'email', 'phone');
  }

  public function employee() {
    return $this->hasOne('ShiftApi\Model\User', 'id', 'employee_id')
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

  public static function shiftsInTimeRange($start_time, $end_time) {
    return self::where('start_time', '>=', $start_time)
      ->where('end_time', '<=', $end_time);
  }

  public static function hoursByWeek($week_of, $employee_id) {
    $week_of_time = strtotime($week_of);
    $begin_string = date("l", $week_of_time) == 'Sunday' ? 'this Sunday' : 'last Sunday';
    $end_string   = 'next Sunday';

    $week_begins = date('Y-m-d H:i:s', strtotime($begin_string, strtotime($week_of)));
    $week_ends = date('Y-m-d H:i:s', strtotime($end_string, strtotime($week_of)));

    $shifts_in_week = self::where('employee_id', $employee_id)
      ->where('start_time', '>=', $week_begins)
      ->where('start_time', '<=', $week_ends)->get();

    $unix_seconds = 0;

    foreach ($shifts_in_week as $shift) {
      $start_time = new \DateTime($shift->start_time);
      $end_time = new \DateTime($shift->end_time);

      $unix_seconds += $end_time->getTimestamp() - $start_time->getTimestamp();
    }

    $hours = $unix_seconds / 60 / 60;

    return [
      'week_begins' => $week_begins,
      'week_ends' => $week_ends,
      'hours' => $hours,
      'shifts' => $shifts_in_week->toArray()
    ];
  }
}
