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
                    <!--<th>Status</th>-->
                    <!--<th>BookingDateTime</th>-->
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Customer</th>
                    <th>Stylist</th>
                    <th></th>
                </tr>
                @foreach($processes as $process)
                    <?php $start_date_time = new \DateTime($process['start_date_time']); ?>
                    <tr>
                        <!--<td>{{$process['status']}}</td>-->
                        <!--<td>{{$process['created_at']}}</td>-->
                        <td>{{date("Y-m-d", $start_date_time->getTimestamp())}}</td>
                        <td>{{date("H:i:s", $start_date_time->getTimestamp())}}</td>
                        <td>{{date("H:i:s", $start_date_time->getTimestamp())}}</td>
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