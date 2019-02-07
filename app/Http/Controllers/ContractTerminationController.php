<?php

namespace App\Http\Controllers;

use App\Termination;
use Illuminate\Http\Request;

class ContractTerminationController extends Controller
{
	public function index()
	{
		return view('contracts.termination');
	}

	public function store(Request $request)
	{
		$this->validate($request, [
			'contract' => 'required',
			'name' => 'required',
			'payoff' => 'required',
			'sale' => 'required',
			'date' => 'required'
		]);

		Termination::create($request->only('contract', 'name', 'payoff', 'sale', 'date'));

		return back()->withSuccess('Form successfuly submited');
	}
}
