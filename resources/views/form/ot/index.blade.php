@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<h3 class="text-center text-underline">តារាងស្នើសុំថែមម៉ោង និងធ្វើការថ្ងៃបុណ្យ</h3>
			<h4 class="text-center text-up">Request Form Over Time / Holiday Working</h4>
		</div>
	</div>
	<br><br>
	<div class="row">
		<div class="col">
		@if(session()->has('success'))
			<div class="alert alert-success" role="alert"><strong>Congratulations! </strong>{{ session('success') }}</div>
		@endif
			<div class="table-responsive">
				<form action="{{ route('form.ot') }}" method="post">
					{{ csrf_field() }}
					<table class="table">
						<tbody>
							<tr>
								<td colspan="2">
								    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    									<label class="control-label">ឈ្មោះ / Name</label>
    									
    									<br><select id="name" class="form-control select2" name="name">
    										<option value="">Enter your name</option>
    										@foreach(\App\Models\Slack::orderBy('name', 'asc')->get() as $slack)
    											<option value="{{ $slack->slackid }}">{{ ucwords(str_replace('.', ' ', $slack->name)) }}</option>
    										@endforeach
    									</select>
    									
    									@if($errors->has('name'))
    										<span class="help-block">
    											{{ $errors->first('name') }}
    										</span>
    									@endif
    								</div>
								</td>
								<td>
									<div class="form-group{{ $errors->has('userid') ? ' has-error' : '' }}">
										<label class="control-label">អត្ថលេខ / ID</label>
										<input id="idcard" value="{{ old('userid') }}" type="text" name="userid" class="form-control">
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
										<input id="department" value="{{ old('department') }}" type="text" name="department" class="form-control">
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
									<label>ចាប់ផ្តើមថ្ងៃ/Start Date</label>
									<input type="date" name="startdate" class="form-control" value="{{ date('Y-m-d') }}">
								</td>
								<td>
									<label>ចាប់ម៉ោង / Start Time</label>
									<input type="time" name="starttime" class="form-control" value="08:00:00">
								</td>
								<td>
									<label>បញ្ចប់ថ្ងៃ / End Date</label>
									<input type="date" name="enddate" class="form-control" value="{{ date('Y-m-d') }}">
								</td>
								<td>
									<label>បញ្ចប់ម៉ោង / End Time</label>
									<input type="time" name="endtime" class="form-control" value="17:00:00">
								</td>
							</tr>
							<tr>
								<td colspan="5"><hr></td>
							</tr>
							<tr>
								<td>
									<div class="control-label{{ $errors->has('reason') ? ' has-error' : '' }}">
										<label class="control-label">មូលហេតុនៃការស្នើសុំ / Reason</label>
										<input value="{{ old('reason') }}" type="text" name="reason" class="form-control">
										@if($errors->has('reason'))
											<span class="help-block">
												{{ $errors->first('reason') }}
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
									<div class="form-group{{ $errors->has('activities') ? ' has-error' : '' }}">
										<label class="activities-label">Activities</label>
										<textarea name="activities" rows="8" class="form-control">{{ old('activities') }}</textarea>
										@if($errors->has('activities'))
											<span class="help-block">
												{{ $errors->first('activities') }}
											</span>
										@endif
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form-group{{ $errors->has('request_to') ? ' has-error' : '' }}">
										<label class="control-label">Request to:</label>
										<select multiple name="request_to[]" class="form-control select2s">
											@foreach(\App\Approver::get() as $key => $approver)
												@if($key == 0)
													<option selected="selected" value="{{ $approver->slackid  }}">
														{{ $approver->name  }}
													</option>
												@else
													<option value="{{ $approver->slackid  }}">
														{{ $approver->name  }}
													</option>
												@endif
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
    $('.select2s').select2();

    $('#name').on('change', function(){
    	$.get('/fetch/data?id='+ this.value, function(response){
    		$('#idcard').val(response.data.card);
    		$('#department').val(response.data.position);
    	})
    });
});
</script>
<link href="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="/css/form.css">

@endsection

