@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>New Booking</h3>
            <hr/>
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Customer Details</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group{{ $errors->has('customer_id') ? ' has-error' : '' }}">
                            <label for="customer_id" class="control-label">Customer</label>
                            <select id="customer_id" class="form-control" name="customer_id" value="{{ old('customer_id') }}">
                                @foreach($customers as $customer)
                                    <option value="{{$customer->id}}">{{$customer->name}}</option>
                                @endforeach
                            </select>
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
                                    <div class='input-group date' id='datetimepicker'>
                                        <input placeholder="2016-12-20 17:16:18" type='text' class="form-control" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    </script>
@endsection
