<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Termination extends Model
{
    protected $fillable = [
    	'contract',
    	'name',
    	'sale',
    	'payoff',
    	'date',
    	'appointment'
    ];
}
