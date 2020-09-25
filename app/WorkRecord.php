<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkRecord extends Model
{
    protected $fillable = [
        'user_id',
        'declared_working_time',
        'start_time',
        'end_time',
        'actual_working_time',
        'shift'
    ];

    protected $dates = [
        'start_time',
        'end_time'
    ];

    public $timestamps = false;

    public function users(){
        return $this->belongsTo('App\User');
    }
}
