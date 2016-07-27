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
                                    <option value="">Select Existing Customer</option>
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
                                <p class="col-md-7" id="dis_name"></p>
                            </div>
                            <div class="col-md-12">
                                <label for="email_address" class="col-md-5 control-label">EmailAddress:</label>
                                <p class="col-md-7" id="dis_email_address"></p>
                            </div>
                            <div class="col-md-12">
                                <label for="phone_number" class="col-md-5 control-label">PhoneNumber:</label>
                                <p class="col-md-7" id="dis_phone_number"></p>
                            </div>
                            <div class="col-md-12">
                                <label for="send_reminders" class="col-md-5 control-label">SendReminders:</label>
                                <p class="col-md-7" id="dis_send_reminders"></p>
                            </div>
                            <div class="col-md-12">
                                <label for="is_student" class="col-md-5 control-label">IsStudent:</label>
                                <p class="col-md-7" id="dis_is_student"></p>
                            </div>
                            <div class="col-md-12">
                                <label for="is_child" class="col-md-5 control-label">IsChild:</label>
                                <p class="col-md-7" id="dis_is_child"></p>
                            </div>
                            <div class="col-md-12">
                                <label for="is_military" class="col-md-5 control-label">IsMilitary:</label>
                                <p class="col-md-7" id="dis_is_military"></p>
                            </div>
                            <div class="col-md-12">
                                <label for="is_beard" class="col-md-5 control-label">HasBeard:</label>
                                <p class="col-md-7" id="dis_is_beard"></p>
                            </div>
                            <div class="col-md-12">
                                <label for="next_reminder" class="col-md-5 control-label">NextReminder:</label>
                                <p class="col-md-7" id="dis_next_reminder"></p>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <p>Or Create a New Customer</p>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <input onkeyup="check_availability()" placeholder="Name" id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('email_address') ? ' has-error' : '' }}">
                                <input onkeyup="check_availability()" placeholder="EmailAdress" id="email_address" type="text" class="form-control" name="email_address" value="{{ old('email_address') }}">

                                @if ($errors->has('email_address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email_address') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                                <input onkeyup="check_availability()" placeholder="PhoneNumber" id="phone_number" type="text" class="form-control" name="phone_number" value="{{ old('phone_number') }}">

                                @if ($errors->has('phone_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('send_reminders') ? ' has-error' : '' }}">
                                <div class="col-md-2">
                                    <input id="send_reminders" type="checkbox" class="checkbox" name="send_reminders" value="{{ old('send_reminders') }}">

                                    @if ($errors->has('send_reminders'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('send_reminders') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <label for="send_reminders" class="col-md-10 control-label">SendReminders</label>
                            </div>

                            <br/><br/>

                            <div class="form-group{{ $errors->has('is_student') ? ' has-error' : '' }}">
                                <label for="is_student" class="col-md-4 control-label">IsStudent</label>

                                <div class="col-md-8">
                                    <select id="is_student" class="form-control" name="is_student" value="{{ old('is_student') }}">
                                        <option value="1">True</option>
                                        <option value="0">False</option>
                                    </select>

                                    @if ($errors->has('is_student'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('is_student') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <br/><br/>

                            <div class="form-group{{ $errors->has('is_child') ? ' has-error' : '' }}">
                                <label for="is_child" class="col-md-4 control-label">IsChild</label>

                                <div class="col-md-8">
                                    <select id="is_child" class="form-control" name="is_child" value="{{ old('is_child') }}">
                                        <option value="1">True</option>
                                        <option value="0">False</option>
                                    </select>

                                    @if ($errors->has('is_child'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('is_child') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <br/><br/>

                            <div class="form-group{{ $errors->has('is_military') ? ' has-error' : '' }}">
                                <label for="is_military" class="col-md-4 control-label">IsMilitary</label>

                                <div class="col-md-8">
                                    <select id="is_military" class="form-control" name="is_military" value="{{ old('is_military') }}">
                                        <option value="1">True</option>
                                        <option value="0">False</option>
                                    </select>

                                    @if ($errors->has('is_military'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('is_military') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <br/><br/>

                            <div class="form-group{{ $errors->has('is_beard') ? ' has-error' : '' }}">
                                <label for="is_beard" class="col-md-4 control-label">HasBeard</label>

                                <div class="col-md-8">
                                    <select id="is_beard" class="form-control" name="is_beard" value="{{ old('is_beard') }}">
                                        <option value="1">True</option>
                                        <option value="0">False</option>
                                    </select>

                                    @if ($errors->has('is_beard'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('is_beard') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <br/><br/>

                            <div class="form-group{{ $errors->has('next_reminder') ? ' has-error' : '' }}">
                                <label for="next_reminder" class="col-md-4 control-label">NextReminder</label>

                                <div class="col-md-8">
                                    <div class='input-group date' id='datetimepicker'>
                                        <input placeholder="2016-12-20 17:16:18" name="next_reminder" id="next_reminder" type='text' class="form-control" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>

                                    @if ($errors->has('next_reminder'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('next_reminder') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
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
                                    <div class='input-group date' id='datetimepicker1'>
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

            <div class="col-md-4">
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

            $('#datetimepicker1').datetimepicker({
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
                        $('#dis_name').html(data.name);
                        $('#dis_email_address').html(data.email_address);
                        $('#dis_phone_number').html(data.phone_number);
                        $('#dis_send_reminders').html((data.send_reminders == 1) ? "Yes" : "No");
                        $('#dis_is_student').html((data.is_student == 1) ? "Yes" : "No");
                        $('#dis_is_child').html((data.is_child == 1) ? "Yes" : "No");
                        $('#dis_is_military').html((data.is_military == 1) ? "Yes" : "No");
                        $('#dis_is_beard').html((data.is_beard == 1) ? "Yes" : "No");
                        $('#dis_next_reminder').html(data.next_reminder);
                    }
                });
            } else {
                $("#customer_details").hide();
            }
        });

        function check_availability() {
            var avail = 0;
            if($('.select2').val() != null && $('#stylist').val() != "" && $('#start').val() != "") {
                if ($('#customer').val() != "") {
                    avail = 1;
                } else if($('#name').val() != "" && $('#email_address').val() != "" && $('#phone_number').val() != "" && $('#next_reminder').val() != "") {
                    avail = 1;
                } else {
                    avail = 0;
                }
            } else {
               avail = 0;
            }

            if(avail == 0){
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

                var customer_id;
                if ($('#customer').val() == "") {
                    customer_id = 0;
                } else {
                    customer_id = $('#customer').val();
                }
                $.ajax({
                    url: '/availability/'+$('#stylist').val()+'/'+customer_id+'/'+$('#start').val()+'/'+$('.select2').val(),
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
                                    +'<i class="fa fa-clock-o"></i> '+value.start_date_time.slice(11,19)
                                    +'<button class="btn btn-danger" type="button">'
                                    +'<i class="fa fa-clock-o"></i> '+value.end_date_time.slice(11,19)
                                    +'</button>'
                                    +'<button class="btn btn-default" type="button">'
                                    +'Services <span class="badge">'+value.service_durations.length+'</span>'
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
