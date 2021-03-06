@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-9 col-md-offset-2" >
                <h1>Add</h1>
                <h4>Customer</h4>
                <hr/>
            </div>
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/customer') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-3 control-label">Name</label>

                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('email_address') ? ' has-error' : '' }}">
                    <label for="email_address" class="col-md-3 control-label">Email Address</label>

                    <div class="col-md-8">
                        <input id="email_address" type="email" class="form-control" name="email_address" value="{{ old('email_address') }}">

                        @if ($errors->has('email_address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email_address') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                    <label for="phone_number" class="col-md-3 control-label">Phone Number</label>

                    <div class="col-md-8">
                        <input id="phone_number" type="text" class="form-control" name="phone_number" value="{{ old('phone_number') }}">

                        @if ($errors->has('phone_number'))
                            <span class="help-block">
                                <strong>{{ $errors->first('phone_number') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('send_reminders') ? ' has-error' : '' }}">
                    <label for="send_reminders" class="col-md-3 control-label">Send Reminders</label>

                    <div class="col-md-1">
                        <input id="send_reminders" type="checkbox" class="checkbox" name="send_reminders" @if(old('send_reminders') == true) checked @endif>

                        @if ($errors->has('send_reminders'))
                            <span class="help-block">
                                <strong>{{ $errors->first('send_reminders') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('is_student') ? ' has-error' : '' }}">
                    <label for="is_student" class="col-md-3 control-label">Student</label>

                    <div class="col-md-1">
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

                <div class="form-group{{ $errors->has('is_child') ? ' has-error' : '' }}">
                    <label for="is_child" class="col-md-3 control-label">Child</label>

                    <div class="col-md-1">
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

                <div class="form-group{{ $errors->has('is_military') ? ' has-error' : '' }}">
                    <label for="is_military" class="col-md-3 control-label">Military</label>

                    <div class="col-md-1">
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

                <div class="form-group{{ $errors->has('is_beard') ? ' has-error' : '' }}">
                    <label for="is_beard" class="col-md-3 control-label">Beard</label>

                    <div class="col-md-1">
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

                <div class="form-group{{ $errors->has('next_reminder') ? ' has-error' : '' }}">
                    <label for="next_reminder" class="col-md-3 control-label">Next Reminder</label>

                    <div class="col-md-8">
                        <input id="next_reminder" type="text" class="form-control" name="next_reminder" placeholder="2016-12-20 17:16:18" value="{{ old('next_reminder') }}">

                        @if ($errors->has('next_reminder'))
                            <span class="help-block">
                                <strong>{{ $errors->first('next_reminder') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-3">
                        <button type="submit" class="btn btn-primary">
                            Create
                        </button>
                    </div>
                </div>
            </form>

            <h5>
                <div class="col-md-9 col-md-offset-2" >
                    <a href="{{ url('/customer') }}">Back to list</a>
                </div>
            </h5>
        </div>
    </div>
</div>
@endsection
