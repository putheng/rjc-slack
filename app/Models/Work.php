<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $filable = [
        'slackid',
        'username',
        'in',
        'out'
    ];
    
    public function scopeIsInToday($query, $id)
    {
        return $query->whereDate('created_at', Carbon::today())
                ->where('slackid', $id);
    }
    
    public function scopeFilter($query)
    {
        return $query->whereBetween('created_at', [
            request()->get('from', null),
            request()->get('to', null)
        ]);
    }
    
}
