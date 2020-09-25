<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'login'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    public function roles(){
        return $this->belongsToMany('App\Role');
    }

    public function departments(){
        return $this->belongsToMany('App\Department');
    }

    public function workRecords(){
        return $this->hasMany('App\WorkRecord');
    }

    public function hasRole($role){
        if($this->roles()->where('name', $role)->first()){
            return true;
        }
        return false;
    }

    public function hasAnyRoles($roles){
        if($this->roles()->whereIn('name', $roles)->first()){
            return true;
        }
        return false;
    }

    /**
     * Check if the user has already started the work
     *
     * @param $user_id integer
     * @return bool
     */
    public function hasWorkStarted(int $user_id){
        $work_started = WorkRecord::whereNull('end_time')->where('user_id', '=', $user_id)->latest('start_time')->get()->first();

        if (!is_null($work_started) && is_null($work_started->end_time)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if the user has already started the operation
     *
     * @param $user_id integer
     * @return bool
     */
    public function hasOperationStarted(int $user_id){
        $operation_started = ProductRecord::whereNull('end_time')->where('user_id', '=', $user_id)->latest('start_time')->get()->first();

        if (!is_null($operation_started) && is_null($operation_started->end_time)) {
            return true;
        } else {
            return false;
        }
    }

}
