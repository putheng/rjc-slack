@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<h4 class="text-center text-up">
				IT SUPPORT request
			</h4>
		</div>
	</div>
	<br><br>
	<div class="row">
		<div class="col">
		@if(session()->has('success'))
			<div class="alert alert-success" role="alert"><strong>Congratulations! </strong>{{ session('success') }}</div>
		@endif
			<div class="table-responsive">
				<form action="{{ route('support.store') }}" method="post">
					{{ csrf_field() }}
					<table class="table">
						<tbody>
							<tr>
								<td colspan="2">
								    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
    									<label class="control-label">ឈ្មោះ / Name</label>
    									
    									<br><select id="name" class="form-control select2" name="username">
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
								<td>
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
								<td>
									<div class="form-group{{ $errors->has('department') ? ' has-error' : '' }}">
										<label class="control-label">ផ្នែក / Department</label>
										<input id="department" type="text" name="department" class="form-control">
										@if($errors->has('department'))
											<span class="help-block">
												{{ $errors->first('department') }}
											</span>
										@endif
									</div>
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
										<label class="control-label">Description</label>
										<textarea name="description" rows="8" class="form-control"></textarea>
										@if($errors->has('reason'))
											<span class="help-block">
												{{ $errors->first('reason') }}
											</span>
										@endif
									</div>
								</td>
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
    		$('#department').val(response.data.department);
    	})
    });
});
</script>
<link href="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="/css/form.css">

@endsection

