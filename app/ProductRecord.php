<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductRecord extends Model
{
    protected $dates = [
        'start_time',
        'end_time'
    ];

    public $timestamps = false;
}
