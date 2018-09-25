@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Slack users</h2>
                
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
                
            </div>
        </div>
    </div>

@endsection