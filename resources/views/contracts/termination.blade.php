@extends('layouts.app')

@section('content')
<form action="{{ route('contract.terminate') }}" method="post">
	<div class="container">
		<div class="row">
			<h3 class="text-center text-underline">Contract Termination</h3>
			<br>
			@if(session()->has('success'))
				<div class="alert alert-success" role="alert"><strong>Congratulations! </strong>{{ session('success') }}</div>
			@endif
			<br>
			<div class="col-md-4 col-md-offset-2">
				<div class="form-group{{ $errors->has('contract') ? ' has-error' : '' }}">
					<label class="control-label">
						Contract No
					</label>
					<input type="type" name="contract" class="form-control" value="{{ old('contract') }}">
					@if($errors->has('contract'))
						<p class="help-block">{{ $errors->first('contract') }}</p>
					@endif
				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
					<label class="control-label">
						Client Name
					</label>
					<input type="type" name="name" class="form-control" value="{{ old('name') }}">
					@if($errors->has('name'))
						<p class="help-block">{{ $errors->first('name') }}</p>
					@endif
				</div>
			</div>

		</div>
		<br>
		<div class="row">
			<div class="col-md-4 col-md-offset-2">
				<div class="form-group{{ $errors->has('payoff') ? ' has-error' : '' }}">
					<label class="control-label">
						Type
					</label>
					<select class="form-control" name="payoff">
						<option value="">--select--</option>
						<option value="Early Termination" {{ old('payoff') == 'Early Termination' ? 'selected' : '' }}>Early Termination</option>
						<option value="Complete Repayments" {{ old('payoff') == 'Complete Repayments' ? 'selected' : '' }}>Complete Repayments</option>
						<option value="Pick Up" {{ old('payoff') == 'Pick Up' ? 'selected' : '' }}>Pick Up</option>
					</select>
					@if($errors->has('payoff'))
						<p class="help-block">{{ $errors->first('payoff') }}</p>
					@endif
				</div>
			</div>


			<div class="col-md-4">
				<div class="form-group{{ $errors->has('sale') ? ' has-error' : '' }}">
					<label class="control-label">
						Sales Staff
					</label>
					<select class="form-control" name="sale">
						<option value="">--select--</option>
						<option {{ old('sale') == 'Vutha, Yon' ? 'selected' : '' }} value="Vutha, Yon">Vutha, Yon</option>
						<option {{ old('sale') == 'Sokcchhat, Chea' ? 'selected' : '' }} value="Sokcchhat, Chea">Sokcchhat, Chea</option>
						<option {{ old('sale') == 'Songheng, Heang' ? 'selected' : '' }} value="Songheng, Heang">Songheng, Heang</option>
						<option {{ old('sale') == 'Sophat, Cheab' ? 'selected' : '' }} value="Sophat, Cheab">Sophat, Cheab</option>
						<option {{ old('sale') == 'Bopha, Oung' ? 'selected' : '' }} value="Bopha, Oung">Bopha, Oung</option>
					</select>
					@if($errors->has('sale'))
						<p class="help-block">{{ $errors->first('sale') }}</p>
					@endif
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-3 col-md-offset-2">
				<div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
					<label class="control-label">
						Termination Date
					</label>
					<input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}">
					@if($errors->has('date'))
						<p class="help-block">{{ $errors->first('date') }}</p>
					@endif
				</div>
			</div>

			<div class="col-md-3">
				<div class="form-group{{ $errors->has('appointment') ? ' has-error' : '' }}">
					<label class="control-label">
						Appointment date
					</label>
					<input type="date" name="appointment" class="form-control">
					@if($errors->has('appointment'))
						<p class="help-block">{{ $errors->first('appointment') }}</p>
					@endif
				</div>
			</div>

			<div class="col-md-2 text-center">
				<br>
				{{ csrf_field() }}
				<input type="submit" value="Submit" class="btn btn-primary btn-block">
			</div>
		</div>
	</div>
</form>
@endsection