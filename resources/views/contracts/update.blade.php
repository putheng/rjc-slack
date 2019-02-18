@extends('layouts.app')

@section('content')
<form action="{{ route('contract.update') }}" method="post">
	<div class="container">
		<h3 class="text-center text-underline" style="text-decoration: underline;">Car Update</h3>


		
		<div class="row">
			@if(session()->has('success'))
				<div class="alert alert-success" role="alert"><strong>Congratulations! </strong>{{ session('success') }}</div>
			@endif
			<br>
			<div class="col-md-4 col-md-offset-2">
				<h4>Current</h4>
				<div class="form-group{{ $errors->has('client_name') ? ' has-error' : '' }}">
					<label class="control-label">
						Client Name
					</label>
					<input type="type" name="client_name" class="form-control" value="{{ old('client_name') }}">
					@if($errors->has('client_name'))
						<p class="help-block">{{ $errors->first('client_name') }}</p>
					@endif
				</div>
			</div>

			<div class="col-md-4">
				<h4>.</h4>
				<div class="form-group{{ $errors->has('vehicle_mark') ? ' has-error' : '' }}">
					<label class="control-label">
						Vehicle Mark
					</label>
					<input type="type" name="vehicle_mark" class="form-control" value="{{ old('vehicle_mark') }}">
					@if($errors->has('vehicle_mark'))
						<p class="help-block">{{ $errors->first('vehicle_mark') }}</p>
					@endif
				</div>
			</div>

		</div>

		<br>
		<div class="row">
			<div class="col-md-4 col-md-offset-2">
				<div class="form-group{{ $errors->has('vehicle_mode') ? ' has-error' : '' }}">
					<label class="control-label">
						Vehicle Mode
					</label>
					<input type="type" name="vehicle_mode" class="form-control" value="{{ old('vehicle_mode') }}">
					@if($errors->has('vehicle_mode'))
						<p class="help-block">{{ $errors->first('vehicle_mode') }}</p>
					@endif
				</div>
			</div>


			<div class="col-md-4">
				<div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
					<label class="control-label">
						Price ($)
					</label>
					<input type="type" name="price" class="form-control" value="{{ old('price') }}">
					@if($errors->has('price'))
						<p class="help-block">{{ $errors->first('price') }}</p>
					@endif
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<br>
			<div class="col-md-4 col-md-offset-2">
				<h4>Request</h4>
				<div class="form-group{{ $errors->has('client_name_update') ? ' has-error' : '' }}">
					<label class="control-label">
						Client Name
					</label>
					<input type="type" name="client_name_update" class="form-control" value="{{ old('client_name_update') }}">
					@if($errors->has('client_name_update'))
						<p class="help-block">{{ $errors->first('client_name_update') }}</p>
					@endif
				</div>
			</div>

			<div class="col-md-4">
				<h4>.</h4>
				<div class="form-group{{ $errors->has('vehicle_mark_update') ? ' has-error' : '' }}">
					<label class="control-label">
						Vehicle Mark
					</label>
					<input type="type" name="vehicle_mark_update" class="form-control" value="{{ old('vehicle_mark_update') }}">
					@if($errors->has('vehicle_mark_update'))
						<p class="help-block">{{ $errors->first('vehicle_mark_update') }}</p>
					@endif
				</div>
			</div>

		</div>

		<br>
		<div class="row">
			<div class="col-md-4 col-md-offset-2">
				<div class="form-group{{ $errors->has('vehicle_mode_update') ? ' has-error' : '' }}">
					<label class="control-label">
						Vehicle Mode
					</label>
					<input type="type" name="vehicle_mode_update" class="form-control" value="{{ old('vehicle_mode_update') }}">
					@if($errors->has('vehicle_mode_update'))
						<p class="help-block">{{ $errors->first('vehicle_mode_update') }}</p>
					@endif
				</div>
			</div>


			<div class="col-md-4">
				<div class="form-group{{ $errors->has('price_update') ? ' has-error' : '' }}">
					<label class="control-label">
						Price ($)
					</label>
					<input type="type" name="price_update" class="form-control" value="{{ old('price_update') }}">
					@if($errors->has('price_update'))
						<p class="help-block">{{ $errors->first('price_update') }}</p>
					@endif
				</div>
			</div>
		</div>
		<br>

		<div class="row">
			<div class="col-md-4 col-md-offset-2">
				<div class="form-group{{ $errors->has('contract_number') ? ' has-error' : '' }}">
					<label class="control-label">
						Contrat No.
					</label>
					<input type="type" name="contract_number" class="form-control" value="{{ old('contract_number') }}">
					@if($errors->has('contract_number'))
						<p class="help-block">{{ $errors->first('contract_number') }}</p>
					@endif
				</div>
			</div>
			<div class="col-md-4 text-center">
				<label class="control-label">
						.
				</label>
				{{ csrf_field() }}
				<input type="submit" value="Submit" class="btn btn-primary btn-block">
			</div>
		</div>
	</div>
</form>
@endsection

@section('script')

@endsection