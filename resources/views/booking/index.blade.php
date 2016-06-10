@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12" >
                <h1>Bookings</h1>
                <a class="btn btn-primary" href="{{ url('/booking/create') }}"><i class="fa fa-btn fa-plus-circle"></i> New Booking</a>
                <hr/>
            </div>
            <div class="col-md-12">
                <div class="container">
                    <div class="row">
                        <div class="span6 btn-group pull-left">
                            <button class="btn btn-warning" data-calendar-view="year">Year</button>
                            <button class="btn btn-warning active" data-calendar-view="month">Month</button>
                            <button class="btn btn-warning" data-calendar-view="week">Week</button>
                            <button class="btn btn-warning" data-calendar-view="day">Day</button>
                        </div>
                        <div class="span6 btn-group pull-right">
                            <button class="btn btn-primary" data-calendar-nav="prev"><< Prev</button>
                            <button class="btn" data-calendar-nav="today">Today</button>
                            <button class="btn btn-primary" data-calendar-nav="next">Next >></button>
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <div class="col-md-12">
                <div class="container">
                    <div class="row">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection