<?php

namespace App;

use App\Models\Slack;
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

    public function slack()
    {
        return $this->belongsTo(Slack::class, 'name', 'slackid');
    }
}
