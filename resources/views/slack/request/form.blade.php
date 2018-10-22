@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<h3 class="text-center text-underline">ពាក្យស្នើសុំចេញក្រៅក្នុងកំឡុងពេលធ្វើការងារ</h3>
			<h4 class="text-center text-up">Permission Leave During Working</h4>
		</div>
	</div>
	<br><br>
	<div class="row">
		<div class="col">
		@if(session()->has('success'))
			<div class="alert alert-success" role="alert"><strong>Congratulations! </strong>{{ session('success') }}</div>
		@endif
			<div class="table-responsive">
				<form action="{{ route('form.approval') }}" method="post">
					{{ csrf_field() }}
					<table class="table">
						<tbody>
							<tr>
								<td colspan="2">
								    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
    									<label class="control-label">ឈ្មោះ / Name</label>
    									<input type="text" name="username" class="form-control">
    									
    									@if($errors->has('username'))
    										<span class="help-block">
    											{{ $errors->first('username') }}
    										</span>
    									@endif
    								</div>
								</td>
								<td>
									<label>អត្ថលេខ / ID</label>
									<input type="text" name="userid" class="form-control{{ $errors->has('userid') ? ' is-invalid' : '' }}">
									@if($errors->has('userid'))
										<span class="invalid-feedback">
											{{ $errors->first('userid') }}
										</span>
									@endif
								</td>
								<td>
									<label>ផ្នែក / Department</label>
									<input type="text" name="department" class="form-control{{ $errors->has('department') ? ' is-invalid' : '' }}">
									@if($errors->has('department'))
										<span class="invalid-feedback">
											{{ $errors->first('department') }}
										</span>
									@endif
								</td>
							</tr>
							<tr>
								<td>
									<label>ថ្ងៃខែឆ្នាំចេញ / Date Out</label>
									<input type="date" name="dateout" class="form-control" value="{{ date('Y-m-d') }}">
								</td>
								<td>
									<label>ម៉ោងចេញ / Time Out</label>
									<input type="time" name="timeout" class="form-control" value="08:00:00">
								</td>
								<td>
									<label>ថ្ងៃខែឆ្នាំចូល / Date In</label>
									<input type="date" name="datein" class="form-control" value="{{ date('Y-m-d') }}">
								</td>
								<td>
									<label>ម៉ោងចូល / Time In</label>
									<input type="time" name="timein" class="form-control" value="17:00:00">
								</td>
							</tr>
							<tr>
								<td colspan="5"><hr></td>
							</tr>
							<tr>
								<td>
									<label>Title</label>
									<input type="text" name="title" class="form-control">
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td colspan="5">
									<label>មូលហេតុនៃការស្នើសុំ / Reason of Leave</label>
									<textarea name="reason" rows="8" class="form-control{{ $errors->has('reason') ? ' is-invalid' : '' }}"></textarea>
									@if($errors->has('reason'))
										<span class="invalid-feedback">
											{{ $errors->first('reason') }}
										</span>
									@endif
								</td>
							</tr>
							<tr>
								<td>
									<label>Request to:</label>
									<select multiple name="request_to[]" class="form-control select2">
										<option value="UCCBRCTCZ">Hirose Daichi</option>
										<option value="UCFNQ3XRU">Shizuka Aoki</option>
										<option value="UCCSTDGE6">Choup Rotha</option>
										<option value="UCCNW35C3">But Kakada</option>
									</select>
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td colspan="5">
									<input type="submit" value="SUBMIT" class="btn btn-primary">
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('script')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $('.select2').select2();
});
</script>
<link href="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="/css/form.css">

@endsection

