<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalApprover extends Model
{
    protected $fillable = [
    	'approval_id',
    	'approver_id'
    ];
}
