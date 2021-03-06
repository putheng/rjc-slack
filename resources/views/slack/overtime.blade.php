@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Slack users
                    <small>This week</small>
                </h2>
                <form action="{{ route('slack.off.filter') }}" method="get">
                
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="from" class="control-label">From:</label>
                                <input value="{{ $date->now()->startOfMonth()->format('Y-m-d') }}" class="form-control input-sm" type="date" name="from"/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="from" class="control-label">To:</label>
                                <input value="{{ $date->now()->endOfMonth()->format('Y-m-d') }}" class="form-control input-sm" type="date" name="to"/>
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
                        {{-- <th>ID</th> --}}
                        <th>NAME</th>
                        <th>REASON</th>
                        <th>IN</th>
                        <th>OUT</th>
                        <th>HOURS</th>
                        <th>STATUS</th>
                    </thead>
                    <tbody>
                        @foreach($slacks as $slack)
                        <tr>
                            {{-- <td>{{ $slack->slackid }}</td> --}}
                            <td>{{ ucwords(str_replace('.', ' ', $slack->slack->name)) }}</td>
                            <td>{{ $slack->reason }}</td>
                            <td>{{ $slack->in }}</td>
                            <td>{{ $slack->out }}</td>
                            <td>{{ $slack->hours }}</td>
                            <td>{{ $slack->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <p>{{ $slacks->links() }}</p>
            </div>
        </div>
    </div>

@endsection