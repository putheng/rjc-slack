<?php

namespace App\Models;

use App\Models\Slack;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $fillable = [
    	'username',
    	'userid',
    	'slackid',
    	'title',
    	'description'
    ];

    public static function boot()
    {
    	parent::boot();

    	static::creating(function($model){
    		$slack = Slack::where('slackid', $model->username)->first();
    		
    		$model->username = $slack->name;
    		$model->slackid = $slack->slackid;
    	});
    }

    public function user()
    {
    	return $this->belongsTo(Slack::class, 'slackid', 'slackid');
    }
}
