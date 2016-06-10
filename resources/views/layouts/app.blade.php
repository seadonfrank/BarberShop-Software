<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Booking System</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="{!! asset('/components/bootstrap3/css/bootstrap.css') !!}">
    <link rel="stylesheet" href="{!! asset('/components/bootstrap3/css/bootstrap-responsive.css') !!}">
    <link rel="stylesheet" href="{!! asset('/css/calendar.css') !!}">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet">
</head>

<body id="app-layout">
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Exeter Barber Shop
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @if (!Auth::guest())
                        <li @if(isset($active) && $active == "booking") class="active" @endif><a href="{{ url('/booking') }}">Bookings</a></li>
                        <li @if(isset($active) && $active == "process_booking") class="active" @endif><a href="{{ url('/home') }}">Process Booking</a></li>
                        <li @if(isset($active) && $active == "customer") class="active" @endif><a href="{{ url('/customer') }}">Customers</a></li>
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li><a href="{{ url('#') }}">Hello {{ Auth::user()->name }}</a></li>
                        <li><a href="{{ url('/logout') }}">Log off</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <hr/>
                <span class="small text-muted">&copy; {{date('Y')}} - Exeter Barber Shop</span>
                <br/><br/>
            </div>
        </div>
    </div>

    <!-- JavaScripts -->
    <script type="text/javascript" src="{!! asset('/components/jquery/jquery.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/components/bootstrap2/js/bootstrap.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/components/underscore/underscore-min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/components/jstimezonedetect/jstz.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/calendar.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/app.js') !!}"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

    @yield('script')

</body>
</html>
