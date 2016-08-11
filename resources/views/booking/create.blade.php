@extends('layouts.app')

@section('style')
    <style type="text/css">
        #customer_chosen {
            width:100% !important;
        }
    </style>
@endsection

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
                                <select id="customer" onchange="check_availability()" style="width:100% !important;" class="col-md-12 chosen form-control" name="customer">
                                    <option value="">Select Existing Customer</option>
                                    @foreach($customers as $customer)
                                        <option @if(old('customer') == $customer->id) selected @endif value="{{$customer->id}}">{{$customer->name}}</option>
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
                            <p><label>Or Create a New Customer</label></p>
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
                                    <input id="send_reminders" type="checkbox" class="checkbox" name="send_reminders" @if(old('send_reminders') == true) checked @endif>

                                    @if ($errors->has('send_reminders'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('send_reminders') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <label style="font-weight: normal !important;" for="send_reminders" class="col-md-10 control-label">SendReminders</label>
                            </div>

                            <br/><br/>

                            <div class="form-group{{ $errors->has('is_student') ? ' has-error' : '' }}">
                                <span class="col-md-4 control-label">Student</span>

                                <div class="col-md-8">
                                    <select id="is_student" class="form-control" name="is_student">
                                        <option @if(old('is_student') == "1") selected @endif value="1">True</option>
                                        <option @if(old('is_student') == "0") selected @endif value="0">False</option>
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
                                <span class="col-md-4 control-label">Child</span>

                                <div class="col-md-8">
                                    <select id="is_child" class="form-control" name="is_child">
                                        <option @if(old('is_child') == "1") selected @endif value="1">True</option>
                                        <option @if(old('is_child') == "0") selected @endif value="0">False</option>
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
                                <span class="col-md-4 control-label">Military</span>

                                <div class="col-md-8">
                                    <select id="is_military" class="form-control" name="is_military">
                                        <option @if(old('is_military') == "1") selected @endif value="1">True</option>
                                        <option @if(old('is_military') == "0") selected @endif value="0">False</option>
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
                                <span class="col-md-4 control-label">Beard</span>

                                <div class="col-md-8">
                                    <select id="is_beard" class="form-control" name="is_beard">
                                        <option @if(old('is_beard') == "1") selected @endif value="1">True</option>
                                        <option @if(old('is_beard') == "0") selected @endif value="0">False</option>
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
                                <span class="col-md-4 control-label">NextReminder</span>

                                <div class="col-md-8">
                                    <div class='input-group date' id='datetimepicker'>
                                        <input placeholder="2016-12-20 17:16:18" name="next_reminder" id="next_reminder" type='text' class="form-control" value="{{ old('next_reminder') }}"/>
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
                            <div class="form-group{{ $errors->has('stylist') ? ' has-error' : '' }}">
                                <label for="stylist" class="control-label">Stylist</label>
                                <select id="stylist" onchange="$(function () { check_availability(); check_stylist_availability(); })" class="form-control" name="stylist">
                                    <option value="">Select a Stylist</option>
                                    @foreach($users as $user)
                                        <option @if(old('stylist') == $user->id) selected @endif value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('stylist'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('stylist') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('services') ? ' has-error' : '' }}">
                                <label for="services" class="control-label">Services</label>
                                <div class="col-md-12">
                                    @foreach($services as $service)
                                        <div class="col-md-6">
                                            <input id="service_{{$service->id}}" onclick="check_availability()" type="checkbox" class="col-md-2 checkbox" name="service_{{$service->id}}" @if(old('service_'.$service->id) == true) checked @endif>
                                            <label style="font-weight: normal !important;" for="service_{{$service->id}}" class="col-md-10 control-label">{{$service->name}}</label>
                                        </div>
                                    @endforeach
                                    <br/><br/>
                                </div>

                                @if ($errors->has('services'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('services') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                                <label for="start_date" class="control-label">Start Date</label>
                                <input name="start_date" id="start_date" type='hidden' class="form-control" />
                                <div id="date_container">
                                </div>

                                @if ($errors->has('start_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('start_date') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('start_time') ? ' has-error' : '' }}">
                                <label for="start_time" class="control-label">Start Time</label>
                                <input name="start_time" id="start_time" type='text' class="form-control" value="{{ old('start_time') }}"/>

                                @if ($errors->has('start_time'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('start_time') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <!--<label for="end" class="control-label">End Date & Time</label>-->
                                <input placeholder="This field will be auto populated" type='hidden' name="end" id="end" class="form-control" disabled />
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
                        <div class="">
                            <div class="form-group">
                                <label for="stylist_availability" class="control-label">Show Stylist Availability</label>
                                <div class="col-md-24">
                                    <div id="stylist_content">
                                        <p>Select a stylist and a start date to see the stylist availability</p>
                                    </div>
                                </div>
                            </div>

                            <hr/>

                            <label id="availability_heading">
                                Enter booking details to check the availability
                            </label>
                            <p id="availability_content">

                            </p>
                        </div>

                        <div class="">
                            <button disabled id="create_booking" type="submit" class="col-md-12  btn btn-success">
                                Place Booking
                            </button>
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

            var pickaday = new Pikaday(
            {
                field: document.getElementById('start_date'),
                bound: false,
                container: document.getElementById('date_container'),
                onSelect: function(date) {
                    var field = document.getElementById('start_date');
                    field.value = date.getFullYear( )+'-'+(date.getMonth( )+1) +'-'+date.getDate( );
                    check_availability();
                    check_stylist_availability();
                }
            });

            $( "#start_time" ).timeDropper({
                format: 'H:mm'
            });

            pickaday.setDate(new Date("{{old('start_date')}}"));
        });

        jQuery(document).ready(function() {
            $(".chosen").chosen();

            $( ".chosen" ).change();
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
            var services = '';
            var i =1;
            @foreach($services as $service)
                if(document.getElementById("service_{{$service->id}}").checked) {
                    if(i != 1) {
                        services += ",";
                    }
                    services += "{{$service->id}}";
                    i++;
                }
            @endforeach

            if(services != "" && $('#stylist').val() != "" && $('#start_date').val() != "" && $('#start_time').val() != "") {
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
                        "Enter booking details to check the availability"
                );

                $('#end').val("This field will be auto populated");

                $('#availability_content').html('');

                document.getElementById("create_booking").disabled = true;
            } else {
                $('#availability_heading').html(
                        "Booking Confirmation for : "+$('#start_date').val()
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
                    url: '/availability/'+$('#stylist').val()+'/'+customer_id+'/'+$('#start_date').val()+' '+$('#start_time').val()+':00/'+services,
                    type: 'get',
                    dataType: 'json',
                    success: function(data) {
                        $('#end').val(data.end_date_time);

                        document.getElementById("create_booking").disabled = !data.available;

                        /*var bookings = '<hr/><div class="btn-group btn-group-xs" role="group">'
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

                        $('#availability_content').html(bookings);*/

                        if(data.available) {
                            $('#availability_content').html('Available <i class="fa fa-check"></i>');
                        } else {
                            $('#availability_content').html('Not Available <i class="fa fa-close"></i>');
                        }
                    }
                });
            }
        }

        function check_stylist_availability() {
            if($('#stylist').val() != "" && $('#start_date').val() != "") {
                var content = '<div class="row"><div class="col-md-6" style="padding-right:3px !important">'
                        +'<input id="stylist_availability_this" onclick="show_stylist_availability(1)" type="radio" class="col-md-1 checkbox" name="stylist_availability">'
                        +'<label style="font-weight: normal !important;" for="stylist_availability_this" class="col-md-10 control-label">This Stylist</label>'
                +'</div><div class="col-md-6" style="padding-right:3px !important">'
                        +'<input id="stylist_availability_all" onclick="show_stylist_availability(0)" type="radio" class="col-md-1 checkbox" name="stylist_availability">'
                        +'<label style="font-weight: normal !important;" for="stylist_availability_all" class="col-md-10 control-label">All Stylist</label>'
                +'</div></div>'
                +'<div id="stylist_availability_content"></div>';
                $('#stylist_content').html(content);

                document.getElementById('stylist_availability_this').checked = true;
                show_stylist_availability(1);
            } else {
                $('#stylist_content').html('<p>Select a stylist and a start date to see the stylist availability</p>');
            }
        }

        function show_stylist_availability(id) {
            $('#stylist_availability_content').html('');

            if(id) {
                id="/"+document.getElementById('stylist').value;
            } else {
                id = "/";
            }

            $.ajax({
                url: '/stylist_availability/'+$('#start_date').val()+' '+$('#start_time').val()+':00'+id,
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    $.each( data, function( key1, value1 ) {
                        $.each( value1, function( key2, value2 ) {
                            if(key2 == "stylist_availabilities_format_default") {
                                $.each( value2, function( key3, value3 ) {
                                    var key = key3;
                                    $.each( value3, function( key4, value4 ) {
                                        $('#stylist_availability_content').append(
                                                '<div class="row"><div class="col-md-6" style="padding-right:3px !important"><a href="#">'+key+'</a></div><div class="col-md-6" style="padding-right:3px !important">'+value4+'</div></div>'
                                        );
                                    });
                                });
                            }
                        });
                    });
                }
            });
        }
    </script>
@endsection
