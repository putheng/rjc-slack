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
	
	public function getUsernameAttribute($value)
	{
		return ucfirst(str_replace('.', ' ', $this->slack($value)->name));
	}
	
    public function scopeFilter($query, $request)
    {
        return $query->whereDate('dateout', '>=', $request->from)
                ->whereDate('dateout', '<=', $request->to);
    }
	
	public function slack($username)
	{
		return Slack::where('slackid', $username)->first();
	}

	public function getApprover()
	{
		$approver = ApprovalApprover::where('approval_id', $this->id)
			->get()->pluck('approver_id');

		return Approver::whereIn('id', $approver)->get()->pluck('name');
	}
	
}
