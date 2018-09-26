@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Slack users</h2>
                <div class="row">
                    <div class="col-md-2">
                        <input class="form-control input-sm" type="text" name="from"/>
                    </div>
                    <div class="col-md-2">
                        <input class="form-control input-sm" type="text" name="from"/>
                    </div>
                    <div class="col-md-2">
                        <input type="submit" class="btn btn-primary btn-sm" value="GO"/>
                    </div>
                </div>
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
            </div>
        </div>
    </div>

@endsection