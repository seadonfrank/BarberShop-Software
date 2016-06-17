@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>New Booking</h2>
            <hr/>
        </div>
        <form class="" role="form" method="POST" action="{{ url('/booking') }}">
            {{ csrf_field() }}
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Customer Details</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('customer') ? ' has-error' : '' }}">
                                <select id="customer" onchange="check_availability()" class="chosen form-control" name="customer" value="{{ old('customer') }}">
                                    <option value="">Select a Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('customer'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('customer') }}</strong>
                            </span>
                                @endif
                            </div>
                        </div>

                        <div class="" id="customer_details" style="display: none">
                            <div class="col-md-12">
                                <label for="name" class="col-md-5 control-label">Name:</label>
                                <p class="col-md-7" id="name"></p>
                            </div>
                            <div class="col-md-12">
                                <label for="email_address" class="col-md-5 control-label">EmailAddress:</label>
                                <p class="col-md-7" id="email_address"></p>
                            </div>
                            <div class="col-md-12">
                                <label for="phone_number" class="col-md-5 control-label">PhoneNumber:</label>
                                <p class="col-md-7" id="phone_number"></p>
                            </div>
                            <div class="col-md-12">
                                <label for="send_reminders" class="col-md-5 control-label">SendReminders:</label>
                                <p class="col-md-7" id="send_reminders"></p>
                            </div>
                            <div class="col-md-12">
                                <label for="is_student" class="col-md-5 control-label">IsStudent:</label>
                                <p class="col-md-7" id="is_student"></p>
                            </div>
                            <div class="col-md-12">
                                <label for="is_child" class="col-md-5 control-label">IsChild:</label>
                                <p class="col-md-7" id="is_child"></p>
                            </div>
                            <div class="col-md-12">
                                <label for="is_military" class="col-md-5 control-label">IsMilitary:</label>
                                <p class="col-md-7" id="is_military"></p>
                            </div>
                            <div class="col-md-12">
                                <label for="is_beard" class="col-md-5 control-label">HasBeard:</label>
                                <p class="col-md-7" id="is_beard"></p>
                            </div>
                            <div class="col-md-12">
                                <label for="next_reminder" class="col-md-5 control-label">NextReminder:</label>
                                <p class="col-md-7" id="next_reminder"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Availability Details</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <label id="availability_heading">
                                Enter the booking details to see availability
                            </label>
                            <p id="availability_content">

                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Booking Details</h3>
                    </div>
                    <div class="panel-body">
                        <div class="">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('stylist') ? ' has-error' : '' }}">
                                    <label for="stylist" class="control-label">Stylist</label>
                                    <select id="stylist" onchange="check_availability()" class="form-control" name="stylist" value="{{ old('stylist') }}">
                                        <option value="">Select a Stylist</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('stylist'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('stylist') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('start') ? ' has-error' : '' }}">
                                    <label for="start" class="control-label">Start Date & Time</label>
                                    <div class='input-group date' id='datetimepicker'>
                                        <input placeholder="2016-12-20 17:16:18" name="start" id="start" type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                    </div>

                                    @if ($errors->has('start'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('start') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="end" class="control-label">End Date & Time</label>
                                    <input placeholder="This field will be auto populated" type='text' name="end" id="end" class="form-control" disabled />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('services') ? ' has-error' : '' }}">
                                    <label for="services" class="control-label">Services</label>
                                    <select id="services" onchange="check_availability()" class="select2 form-control" name="services[]" multiple="true" value="{{ old('services') }}">
                                        @foreach($services as $service)
                                            <option value="{{$service->id}}">{{$service->name}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('services'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('services') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="">
                                <button disabled id="create_booking" type="submit" class="col-md-12  btn btn-success">
                                    Create Booking
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD H:mm:ss'
            }).on('dp.change', function (event) {
                check_availability();
            });
        });


        jQuery(document).ready(function() {
            $(".chosen").chosen();
            $(".select2").chosen();
        });

        $( ".chosen" ).change(function() {
            if($( ".chosen option:selected" ).val() != "") {
                $("#customer_details").show();
                $.ajax({
                    url: '/customer/'+$( ".chosen option:selected" ).val(),
                    type: 'get',
                    dataType: 'json',
                    success: function(data) {
                        $('#name').html(data.name);
                        $('#email_address').html(data.email_address);
                        $('#phone_number').html(data.phone_number);
                        $('#send_reminders').html((data.send_reminders == 1) ? "Yes" : "No");
                        $('#is_student').html((data.is_student == 1) ? "Yes" : "No");
                        $('#is_child').html((data.is_child == 1) ? "Yes" : "No");
                        $('#is_military').html((data.is_military == 1) ? "Yes" : "No");
                        $('#is_beard').html((data.is_beard == 1) ? "Yes" : "No");
                        $('#next_reminder').html(data.next_reminder);
                    }
                });
            } else {
                $("#customer_details").hide();
            }
        });

        function check_availability() {
            if($('.select2').val() == null || $('#customer').val() == "" || $('#stylist').val() == "" || $('#start').val() == ""){
                $('#availability_heading').html(
                    "Enter the booking details to see availability"
                );

                $('#end').val("This field will be auto populated");

                $('#availability_content').html('');

                document.getElementById("create_booking").disabled = true;
            } else {
                $('#availability_heading').html(
                    "Showing availability for the day : "+$('#start').val().slice(0,10)
                );

                $('#availability_content').html('');

                document.getElementById("create_booking").disabled = true;

                $.ajax({
                    url: '/availability/'+$('#stylist').val()+'/'+$('#customer').val()+'/'+$('#start').val()+'/'+$('.select2').val(),
                    type: 'get',
                    dataType: 'json',
                    success: function(data) {
                        $('#end').val(data.end_date_time);

                        document.getElementById("create_booking").disabled = !data.available;

                        var bookings = '<hr/><div class="btn-group btn-group-xs" role="group">'
                                +'No bookings information found'
                                +'</div>';

                        $.each(data.availabilities, function( key, value ) {
                            bookings = '<hr/><div class="btn-group btn-group-xs" role="group">'
                                    +'<button class="btn btn-warning" type="button">'
                                    +'<i class="fa fa-calendar"></i> '+value.start_date_time
                                    +'<button class="btn btn-danger" type="button">'
                                    +'<i class="fa fa-calendar"></i> '+value.end_date_time
                                    +'</button>'
                                    +'</div><br/>'
                                    +'<div class="btn-group btn-group-xs" role="group">'
                                    +'<i class="fa fa-scissors"></i> '+value.user.name
                                    +' | '
                                    +'<i class="fa fa-user"></i> '+value.customer.name
                                    +'</div>';
                        });

                        $('#availability_content').html(bookings);
                    }
                });
            }
        }
    </script>
@endsection
