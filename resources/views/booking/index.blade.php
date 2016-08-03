@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12" >
                <h2>Bookings</h2>
                <a class="btn btn-primary" href="{{ url('/booking/create') }}"><i class="fa fa-btn fa-plus-circle"></i> New Booking</a>
                <hr/>
            </div>
            <div class="col-md-12 page-header">
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
                <div class="text-center row col-md-12">
                    <h3></h3>
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

<!-- Modal -->
<div class="modal fade" id="details" tabindex="-1" role="dialog" aria-labelledby="booking_details">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="title"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <h5><i class="fa fa-user"></i> <span id="customer"></span></h5>
                            <h5><i class="fa fa-scissors"></i> <span id="user"></span></h5>
                            <h5><i class="fa fa-info"></i> <span id="status"></span></h5>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fa fa-clock-o"></i> <span id="start"></span></h5>
                            <h5><i class="fa fa-clock-o"></i> <span id="end"></span></h5>
                            <h5><i class="fa fa-gbp"></i> <span id="cost"></span></h5>
                        </div>
                        <h5 class="col-md-12"><i class="fa fa-cart-plus"></i> <span id="service_names"></span></h5>
                        <div id="next_booking_form">
                            <hr/><br/>
                            <div class="form-group">
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="next_reminder" placeholder="2016-12-20 17:16:18">
                                </div>
                                <button id="set_reminder" class="col-md-4 btn btn-primary">Set Next Reminder</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="process_booking" href="#" class="btn btn-success"><i class="fa fa-gears"></i> Process Booking</a>
                <a id="edit_booking" class="btn btn-warning"><i class="fa fa-pencil-square-o"></i> Edit Booking</a>
                <a id="next_booking_button" href="/booking/create" class="btn btn-info"><i class="fa fa-file"></i> Book Next Appointment</a>
                <button type="button" id="delete_booking" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-trash-o"></i> Remove Booking</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        (function($) {

            "use strict";

            var options = {
                events_source: '/events',
                view: 'week',
                tmpl_path: 'tmpls/',
                tmpl_cache: false,
                day: new Date().toISOString().slice(0,10),
                onAfterEventsLoad: function(events) {
                    if(!events) {
                        return;
                    }
                    var list = $('#eventlist');
                    list.html('');

                    $.each(events, function(key, val) {
                        $(document.createElement('li'))
                                .html('<a href="#">' + val.title + '</a>')
                                .appendTo(list);
                    });
                },
                onAfterViewLoad: function(view) {
                    $('.page-header h3').text(this.getTitle());
                    $('.btn-group button').removeClass('active');
                    $('button[data-calendar-view="' + view + '"]').addClass('active');
                },
                classes: {
                    months: {
                        general: 'label'
                    }
                }
            };

            var calendar = $('#calendar').calendar(options);

            $('.btn-group button[data-calendar-nav]').each(function() {
                var $this = $(this);
                $this.click(function() {
                    calendar.navigate($this.data('calendar-nav'));
                });
            });

            $('.btn-group button[data-calendar-view]').each(function() {
                var $this = $(this);
                $this.click(function() {
                    calendar.view($this.data('calendar-view'));
                });
            });

            $('#events-modal .modal-header, #events-modal .modal-footer').click(function(e){
                //e.preventDefault();
                //e.stopPropagation();
            });
        }(jQuery));

        function detail_booking(id) {
            $('#details').modal('show');

            $('#delete_booking').attr('onclick', 'delete_booking('+id+')');

            $('#process_booking').attr('onclick', 'process_booking('+id+')');

            $('#edit_booking').attr('href', '/booking/'+id+'/edit');

            $.ajax({
                url: '/booking/'+id,
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    $('#title').html("Booking Summary - "+data.start_date_time.slice(0,10));
                    $('#user').html(data.user.name);
                    $('#customer').html(data.customer.name);
                    $('#start').html(data.start_date_time.slice(11,19));
                    $('#end').html(data.end_date_time.slice(11,19));
                    $('#status').html(data.status);
                    var cost = parseFloat(0);
                    $.each(data.service_costs, function( key, value ) {
                        cost = parseFloat(cost,2)+ parseFloat(value,2);
                    });
                    $('#cost').html(cost);
                    $('#service_names').html(data.service_names.join(', '));

                    $('#set_reminder').attr('onclick', 'set_reminder('+data.customer.id+')');
                    $('#process_booking').attr('href', '/process/'+id);

                    if(data.status == "Processed") {
                        $('#next_booking_button').show();
                        $('#next_booking_form').show();
                        $('#edit_booking').hide();
                        $('#process_booking').hide();
                    } else if(data.status == "Finalised") {
                        $('#next_booking_button').hide();
                        $('#next_booking_form').hide();
                        $('#edit_booking').show();
                        $('#process_booking').show();
                    } else if(data.status == "Canceled") {
                        $('#next_booking_button').hide();
                        $('#next_booking_form').hide();
                        $('#edit_booking').show();
                        $('#process_booking').hide();
                    }
                }
            });
        }

        function delete_booking(id){
            if(confirm("Are you sure that you want to delete?")){
                $.ajax({
                    url: '/booking/'+id,
                    type: 'delete',
                    dataType: 'json',
                    success: function(data) {
                        if(data.response) {
                            location.reload();
                        } else {
                            alert("Unable to delete. Please try in some time.");
                        }
                    }
                });
            }
        }

        function set_reminder(id) {
            $.ajax({
                url: '/set_reminder/'+id,
                type: 'put',
                dataType: 'json',
                data: { next_reminder: $('#next_reminder').val() },
                success: function(data) {
                    if(data.response) {
                        location.reload();
                    } else {
                        alert("Unable to set reminder. Please check the date format or try in some time.");
                    }
                }
            });
        }
    </script>
@endsection