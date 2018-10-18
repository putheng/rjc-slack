@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Slack users</h2>
                <form action="{{ route('slack.filter') }}" method="get">
                
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
                        <th>
                            NAME
                        </th>
                        <th>
                            IN
                        </th>
                        <th>
                            OUT
                        </th>
                    </thead>
                    <tbody>
                        @foreach($slacks as $slack)
                        <tr>
                            <td>{{ $slack->slackid }}</td>
                            <td>{{ ucwords($slack->username) }}</td>
                            <td>{{ $slack->created_at }}</td>
                            <td>{{ $slack->updated_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <p>{{ $slacks->links() }}</p>
                <form target="_blank" action="{{ route('slack.filter.export') }}" method="post">
                    {{ csrf_field() }}
                    <input value="{{ request()->from }}" class="form-control input-sm" type="hidden" name="from"/>
                    <input value="{{ request()->to }}" class="form-control input-sm" type="hidden" name="to"/>
                    <input type="submit" value="Export as CSV" class="btn btn-link">
                </form>
                <br>
                <br>
            </div>
        </div>
    </div>

@endsection