@extends('layouts.app')

@section('content')

    <div class="container">
        @if(session()->has('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <h4>Report Day Off
                    <small>This week</small>
                </h4>
                <form action="{{ route('slack.reportDayFilter') }}" method="get">
                
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="from" class="control-label">From:</label>
                                <input value="{{ request()->from }}" class="form-control input-sm" type="date" name="from"/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="from" class="control-label">To:</label>
                                <input value="{{ request()->to }}" class="form-control input-sm" type="date" name="to"/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input type="submit" class="btn btn-primary" value="GO"/>
                        </div>
                    </div>
                    
                </form>
                <br>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Out</th>
                            <th>In</th>
                            <th>Hours</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th class="text-center">Approve</th>
                            <th class="text-center">Reject</th>
                            <th class="text-center">Delete</th>
                            <th class="text-center">Approved By</th>
                        </thead>
                        <tbody>
                            @foreach($approvals as $approval)
                            <tr>
                                <td>{{ $approval->userid }}</td>
                                <td>
                                    @if($approval->slack->count())
                                        {{ ucwords(str_replace('.', ' ', $approval->slack->name)) }}
                                    @endif
                                </td>
                                <td>{{ $approval->type }}</td>
                                <td>{{ $approval->dateout }} </td>
                                <td>{{ $approval->datein }}</td>
                                <td>{{ date_cal($approval->dateout, $approval->datein) }} hours</td>
                                <td>{{ $approval->reason }}</td>
                                <td>{{ ucwords($approval->status) }}</td>
                                <td class="text-center">
                                    <button onclick="approve('{{ $approval->id }}')" class="btn btn-success">Approve</button>
                                    <form id="approve_{{ $approval->id }}" action="{{ route('update.approve', $approval) }}" method="post">
                                        {{ csrf_field() }}
                                    </form>
                                </td>
                                <td class="text-center">
                                    <button onclick="reject('{{ $approval->id }}')" class="btn btn-warning">Reject</button>
                                    <form id="reject_{{ $approval->id }}" action="{{ route('update.reject', $approval) }}" method="post">
                                        {{ csrf_field() }}
                                    </form>
                                </td>
                                <td class="text-center">
                                    <button onclick="deletes('{{ $approval->id }}')" class="btn btn-danger">Delete</button>
                                    <form id="delete_{{ $approval->id }}" action="{{ route('update.delete', $approval) }}" method="post">
                                        {{ csrf_field() }}
                                    </form>
                                </td>
                                <td>
                                    @if($approval->getApprover()->count())
                                        {{ implode(', ', $approval->getApprover()->toArray()) }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <p>{{ $approvals->links() }}</p>

                <form action="{{ route('slack.exportReport') }}" method="post">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <input type="hidden" name="from" value="{{ request()->from }}">
                    <input type="hidden" name="to" value="{{ request()->to }}">
                    <button class="btn btn-link">Export CSV</button>
                </form>
            </div>
        </div>
    </div>
<script type="text/javascript">
    function approve(id){
        if(confirm('Are you sure you want to approve ?')){
            $('#approve_'+ id).submit();
        }
    }

    function reject(id){
        if(confirm('Are you sure you want to reject ?')){
            $('#reject_'+ id).submit();
        }
    }

    function deletes(id){
        if(confirm('Are you sure you want to delete ?')){
            $('#delete_'+ id).submit();
        }
    }
</script>
@endsection