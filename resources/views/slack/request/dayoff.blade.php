@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<h3 class="text-center text-underline">ពាក្យសុំច្បាប់ឈប់សំរាក</h3>
			<h4 class="text-center text-up">Leave Request Form</h4>
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
									<div class="form-group{{ $errors->has('userid') ? ' has-error' : '' }}">
										<label class="control-label">អត្ថលេខ / ID</label>
										<input type="text" name="userid" class="form-control">
										@if($errors->has('userid'))
											<span class="help-block">
												{{ $errors->first('userid') }}
											</span>
										@endif
									</div>
								</td>
								<td>
									<div class="form-group{{ $errors->has('department') ? ' has-error' : '' }}">
										<label class="control-label">ផ្នែក / Department</label>
										<input type="text" name="department" class="form-control">
										@if($errors->has('department'))
											<span class="help-block">
												{{ $errors->first('department') }}
											</span>
										@endif
									</div>
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
									<div class="control-label{{ $errors->has('title') ? ' has-error' : '' }}">
										<label class="control-label">Title</label>
										<input type="text" name="title" class="form-control">
										@if($errors->has('title'))
											<span class="help-block">
												{{ $errors->first('title') }}
											</span>
										@endif
									</div>
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td colspan="5">
									<div class="form-group{{ $errors->has('reason') ? ' has-error' : '' }}">
										<label class="control-label">មូលហេតុនៃការស្នើសុំ / Reason of Leave</label>
										<textarea name="reason" rows="8" class="form-control"></textarea>
										@if($errors->has('reason'))
											<span class="help-block">
												{{ $errors->first('reason') }}
											</span>
										@endif
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
										<label class="control-label">ប្រភេទនៃការសុំឈប់សម្រាក / Type of Leave</label>
										<select name="type" class="form-control">
											<option value="Annual Leave">ច្បាប់សម្រាកប្រចាំឆ្នាំ Annual Leave</option>
											<option value="Special Leave">ច្បាប់ពិសេស Special Leave</option>
											<option value="Maternity Leave">ច្បាប់សម្រាលកូន Maternity Leave</option>
											<option value="Unpaid Leave">ច្បាប់សម្រាកគ្មានប្រាក់ឈ្នួល Unpaid Leave</option>
											<option value="Sick Leave">ច្បាប់ឈឺ Sick Leave</option>
											<option value="Replace day">ប្តូថ្ងៃសម្រាក Replace day</option>
										</select>
										@if($errors->has('type'))
											<span class="help-block">
												{{ $errors->first('type') }}
											</span>
										@endif
									</div>
								</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>
									<div class="form-group{{ $errors->has('request_to') ? ' has-error' : '' }}">
										<label class="control-label">Request to:</label>
										<select multiple name="request_to[]" class="form-control select2">
											<option value="UCCBRCTCZ">Hirose Daichi</option>
											<option value="UCFNQ3XRU">Shizuka Aoki</option>
											<option value="UCCSTDGE6">Choup Rotha</option>
											<option value="UCF3N7R5G">Niioka Naoki</option>
											<option value="UCCNW35C3">But Kakada</option>
										</select>
									</div>
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td colspan="5">
									<input type="hidden" name="id" value="{{ request()->id }}"/>
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

