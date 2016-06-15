@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>New Booking</h3>
            <hr/>
            <form class="" role="form" method="POST" action="{{ url('/customer') }}">
                {{ csrf_field() }}
                <div class="col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Customer Details</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group{{ $errors->has('customer_id') ? ' has-error' : '' }}">
                                <select id="customer_id" class="chosen form-control" name="customer_id" value="{{ old('customer_id') }}">
                                    <option value="">Select a Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row" id="customer_details" style="display: none">
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
                            <h3 class="panel-title">Availability</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">

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
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                                        <label for="user_id" class="control-label">Stylist</label>
                                        <select id="user_id" class="form-control" name="user_id" value="{{ old('user_id') }}">
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="start" class="control-label">Start Date & Time</label>
                                        <div class='input-group date' id='datetimepicker'>
                                            <input placeholder="2016-12-20 17:16:18" name="start" id="start" type='text' class="form-control" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="end" class="control-label">End Date & Time</label>
                                        <input placeholder="2016-12-20 17:16:18" type='text' name="end" id="end" class="form-control" disabled />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('service_id') ? ' has-error' : '' }}">
                                        <label for="service_id" class="control-label">Services</label>
                                        <select id="service_id" class="select2 form-control" name="service_id" multiple="true" value="{{ old('service_id') }}">
                                            @foreach($services as $service)
                                                <option value="{{$service->id}}">{{$service->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="col-md-12 btn btn-success">
                                Create Booking
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD H:mm:ss'
            });
        });

        jQuery(document).ready(function(){
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
    </script>
@endsection
