<?php

namespace App\Http\Controllers\Slack;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use Illuminate\Http\Request;

class ActionController extends Controller
{
	public function approve(Request $request, Approval $approval)
	{
		$approval->update(['status' => 'Approved']);

		return back()->withSuccess('Successfully approved');;
	}

	public function delete(Request $request, Approval $approval)
	{
		$approval->delete();

		return back()->withSuccess('Successfully delete');;
	}

	public function rejecte(Request $request, Approval $approval)
	{
		$approval->update(['status' => 'Rejected']);

		return back()->withSuccess('Successfully rejected');;
	}
}
