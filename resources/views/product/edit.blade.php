@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-9 col-md-offset-2" >
                <h1>Edit</h1>
                <h4>Product</h4>
                <hr/>
            </div>
            <form class="form-horizontal" role="form" method="post" action="{{ url('/product/'.$product[0]->id) }}">
                {{ csrf_field() }}

                <input type="hidden" name="_method" value="put" />
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-3 control-label">Name</label>

                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="name" value="{{ $product[0]->name }}">

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
                        <input id="cost" type="text" class="form-control" name="cost" value="{{ $product[0]->cost }}">

                        @if ($errors->has('cost'))
                            <span class="help-block">
                                <strong>{{ $errors->first('cost') }}</strong>
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
                    <a href="{{ url('/product') }}">Back to list</a>
                </div>
            </h5>
        </div>
    </div>
</div>
@endsection
