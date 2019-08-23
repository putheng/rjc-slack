@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<h3 class="text-center text-underline">ពាក្យសុំច្បាប់ឈប់សំរាក</h3>
			<h4 class="text-center text-up">Leave Request Form</h4>
			<br>
			<p class="text-center h5">រាល់ការឈប់សំរាករបស់អ្នកមានការយលព្រមពីនាក់គ្រប់គ្រងជាមុនសិន</p>
			<p class="text-center h5">Your request for leave permission must be sumitted and approveal from supervisor in advance.</p>

		</div>
	</div>
	<br><br>
	<div class="row">
		<div class="col">
		@if(session()->has('success'))
			<div class="alert alert-success" role="alert"><strong>Congratulations! </strong>{{ session('success') }}</div>
		@endif
			<div class="table-responsive">
				<form action="{{ route('form.approval.leave') }}" method="post">
					{{ csrf_field() }}
					<table class="table">
						<tbody>
							<tr>
								<td style="width: 25%">
								    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
    									<label class="control-label">ឈ្មោះ / Name</label>
    									<br>
    									<select id="name" class="form-control select2" name="username">
    										<option value="">Enter your name</option>
    										@foreach(\App\Models\Slack::orderBy('name', 'asc')->get() as $slack)
    											<option value="{{ $slack->slackid }}">{{ ucwords(str_replace('.', ' ', $slack->name)) }}</option>
    										@endforeach
    									</select>
    									
    									@if($errors->has('username'))
    										<span class="help-block">
    											{{ $errors->first('username') }}
    										</span>
    									@endif
    								</div>
								</td>
								<td style="width: 25%">
									<div class="form-group{{ $errors->has('userid') ? ' has-error' : '' }}">
										<label class="control-label">អត្ថលេខ / ID</label>
										<input id="idcard" type="text" name="userid" class="form-control">
										@if($errors->has('userid'))
											<span class="help-block">
												{{ $errors->first('userid') }}
											</span>
										@endif
									</div>
								</td>
								<td style="width: 25%">
									<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
										<label class="control-label">Phone Number</label>
										<input id="phone" type="text" name="phone" class="form-control">
										@if($errors->has('phone'))
											<span class="help-block">
												{{ $errors->first('phone') }}
											</span>
										@endif
									</div>
								</td>
								<td style="width: 25%">
									<div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
										<label class="control-label">មុខតំណែង / Position</label>
										<input id="position" type="text" name="position" class="form-control">
										@if($errors->has('position'))
											<span class="help-block">
												{{ $errors->first('position') }}
											</span>
										@endif
									</div>
								</td>
							</tr>
							<tr>
								<td style="width: 30%">
									<label>ថ្ងៃខែឆ្នាំចេញ / Date Out</label>
									<input type="date" name="dateout" class="form-control" value="{{ date('Y-m-d') }}">
								</td>
								<td style="width: 20%">
									<label>ម៉ោងចេញ / Time Out</label>
									<input type="time" name="timeout" class="form-control" value="08:00:00">
								</td>
								<td style="width: 30%">
									<label>រហូតដល់ថ្ងៃ / Until Date</label>
									<input type="date" name="datein" class="form-control" value="{{ date('Y-m-d') }}">
								</td>
								<td style="width: 20%">
									<label>រហូតដល់ម៉ោង / Until Time</label>
									<input type="time" name="timein" class="form-control" value="17:00:00">
								</td>
							</tr>
							<tr>
								<td colspan="5"><hr></td>
							</tr>
							<tr>
								<td>
									<div class="control-label{{ $errors->has('branch') ? ' has-error' : '' }}">
										<label class="control-label">សាខា / Branch</label>
										<input id="branch" type="text" name="branch" class="form-control">
										@if($errors->has('branch'))
											<span class="help-block">
												{{ $errors->first('branch') }}
											</span>
										@endif
									</div>
								</td>
								<td>
									<div class="control-label{{ $errors->has('section') ? ' has-error' : '' }}">
										<label class="control-label">ផ្នែក / Section</label>
										<input id="section" type="text" name="section" class="form-control">
										@if($errors->has('section'))
											<span class="help-block">
												{{ $errors->first('section') }}
											</span>
										@endif
									</div>
								</td>
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
								<td>
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
								<td></td>
							</tr>
							<tr>
								<td>
									<div class="form-group{{ $errors->has('request_to') ? ' has-error' : '' }}">
										<label class="control-label">Request to:</label>
										<select multiple name="request_to[]" class="form-control select2">
											@foreach(\App\Approver::orderBy('id', 'desc')->get() as $approver)
												<option value="{{ $approver->slackid  }}">
													{{ $approver->name  }}
												</option>
											@endforeach
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

	$('#name').on('change', function(){
    	$.get('/fetch/data?id='+ this.value, function(response){
    		$('#idcard').val(response.data.card);
    		$('#phone').val(response.data.phone);
    		$('#position').val(response.data.position);
    		$('#branch').val(response.data.department);
    	})
    });
});
</script>
<link href="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="/css/form.css">

@endsection

