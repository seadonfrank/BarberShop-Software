@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12" >
                <h2>Process Bookings</h2>
            </div>
            <table class="table">
                <tr>
                    <th>Status</th>
                    <th>Booking Date</th>
                    <th>StartTime</th>
                    <th>EndTime</th>
                    <th>CustomerName</th>
                    <th>StylistName</th>
                    <th></th>
                </tr>
                @foreach($processes as $process)
                    <tr>
                        <td>{{$process['status']}}</td>
                        <td>{{$process['created_at']}}</td>
                        <td>{{$process['start_date_time']}}</td>
                        <td>{{$process['end_date_time']}}</td>
                        <td>{{$process['customer']['name']}}</td>
                        <td>{{$process['user']['name']}}</td>
                        <td>
                            <a href="/process/{{$process['id']}}" class="btn-xs btn btn-success"><i class="fa fa-gears"></i> Process</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection