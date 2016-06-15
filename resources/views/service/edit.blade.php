@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-9 col-md-offset-2" >
                <h1>Edit</h1>
                <h4>Service</h4>
                <hr/>
            </div>
            <form class="form-horizontal" role="form" method="post" action="{{ url('/service/'.$service[0]->id) }}">
                {{ csrf_field() }}

                <input type="hidden" name="_method" value="put" />
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-3 control-label">Name</label>

                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="name" value="{{ $service[0]->name }}">

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('cost') ? ' has-error' : '' }}">
                    <label for="cost" class="col-md-3 control-label">Cost</label>

                    <div class="col-md-8">
                        <input id="cost" type="text" class="form-control" name="cost" value="{{ $service[0]->cost }}">

                        @if ($errors->has('cost'))
                            <span class="help-block">
                                <strong>{{ $errors->first('cost') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('duration') ? ' has-error' : '' }}">
                    <label for="cost" class="col-md-3 control-label">Duration</label>

                    <div class="col-md-8">
                        <div class='input-group date' id='datetimepicker'>
                            <input placeholder="17:16:18" type='text' class="form-control"  name="duration" value="{{ $service[0]->duration }}" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>

                        @if ($errors->has('duration'))
                            <span class="help-block">
                                <strong>{{ $errors->first('duration') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-3">
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                    </div>
                </div>
            </form>

            <h5>
                <div class="col-md-9 col-md-offset-2" >
                    <a href="{{ url('/service') }}">Back to list</a>
                </div>
            </h5>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker').datetimepicker({
                format: 'H:mm:ss'
            });
        });
    </script>
@endsection
