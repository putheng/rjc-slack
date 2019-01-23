<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OverTime extends Model
{
    protected $fillable = [
    	'name',
    	'userid',
    	'department',
    	'reason',
    	'activities',
    	'created_at',
    	'updated_at',
    	'hours',
    	'status'
    ];
}
