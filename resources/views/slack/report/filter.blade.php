@extends('layouts.app')

@section('content')

    <div class="container">
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
                <table class="table table-striped table-bordered">
                    <thead>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>TYPE</th>
                        <th>DATE</th>
                        <th>HOURS</th>
                        <th>REASON</th>
                        <th>STATUS</th>
                    </thead>
                    <tbody>
                        @foreach($approvals as $approval)
                        <tr>
                            <td>{{ $approval->userid }}</td>
                            <td>{{ $approval->username }}</td>
                            <td>{{ $approval->type }}</td>
                            <td>{{ $approval->dateout }} -> {{ $approval->datein }} </td>
                            <td>{{ date_cal($approval->dateout, $approval->datein) }} hours</td>
                            <td>{{ $approval->reason }}</td>
                            <td>{{ ucwords($approval->status) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
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

@endsection