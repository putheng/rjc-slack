<?php

namespace App\Models;

use App\Approver;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
	protected $fillable = [
		'username',
		'userid',
		'department',
		'dateout',
		'datein',
		'reason',
		'title',
		'status',
		'slackid',
		'type',
		'body'
	];
	
	public function getSlackNameAttribute()
	{
		return ucfirst(str_replace('.', ' ', $this->slack->name));
	}
	
    public function scopeFilter($query, $request)
    {
        return $query->whereDate('dateout', '>=', $request->from)
                ->whereDate('dateout', '<=', $request->to);
    }
	
	public function slack()
	{
		return $this->belongsTo(Slack::class, 'username', 'slackid');
	}

	public function getApprover()
	{
		$approver = ApprovalApprover::where('approval_id', $this->id)
			->get()->pluck('approver_id');

		return Approver::whereIn('id', $approver)->get()->pluck('name');
	}
	
}
