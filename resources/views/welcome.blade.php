@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Booking System</h1>
                    @if (Auth::guest())
                        <a href="{{ url('/login') }}" class="btn btn-primary">
                            Login to Continue &nbsp; <i class="fa fa-forward"></i>
                        </a>
                    @endif
                    <br/><br/>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
