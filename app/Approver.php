<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Approver extends Model
{
    protected $fillable = [
    	'name', 'slackid'
    ];
}
