@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Process Booking</h2>
                <hr/>
            </div>
            <form class="" role="form" method="POST" action="{{ url('/process/'.$id) }}">
                {{ csrf_field() }}
                <div class="col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Booking Summary</h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p><label>Booking Date : </label> {{$process[$id]['start_date']}}</p>
                                    <p><label>Booking Time : </label> {{$process[$id]['start_time']}}</p>
                                    <p><label>Stylist Name : </label> {{$process[$id]['user']->name}}</p>
                                    <p><label>Stylist Email : </label> {{$process[$id]['user']->email}}</p>
                                </div>
                            </div>

                            <hr/>

                            <div class="col-md-12">
                                <p><label>Customer Details</label></p>

                                <input id="customer_id" type="hidden" class="form-control" name="customer_id" value="{{$process[$id]['customer']->id}}">

                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <input placeholder="Name" id="name" type="text" class="form-control" name="name" value="{{$process[$id]['customer']->name}}">

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('email_address') ? ' has-error' : '' }}">
                                    <input disabled placeholder="EmailAdress" id="email_address" type="text" class="form-control" name="email_address" value="{{$process[$id]['customer']->email_address}}">

                                    @if ($errors->has('email_address'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email_address') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                                    <input placeholder="PhoneNumber" id="phone_number" type="text" class="form-control" name="phone_number" value="{{$process[$id]['customer']->phone_number}}">

                                    @if ($errors->has('phone_number'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('phone_number') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('send_reminders') ? ' has-error' : '' }}">
                                    <div class="col-md-2">
                                        <input id="send_reminders" type="checkbox" class="checkbox" name="send_reminders" @if($process[$id]['customer']->send_reminders) checked @endif>

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
                                        <select id="is_student" class="form-control" name="is_student" value="{{ old('is_student') }}">
                                            <option value="1" @if($process[$id]['customer']->is_student) selected @endif>True</option>
                                            <option value="0" @if(!$process[$id]['customer']->is_student) selected @endif>False</option>
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
                                        <select id="is_child" class="form-control" name="is_child" value="{{ old('is_child') }}">
                                            <option value="1" @if($process[$id]['customer']->is_child) selected @endif>True</option>
                                            <option value="0" @if(!$process[$id]['customer']->is_child) selected @endif>False</option>
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
                                        <select id="is_military" class="form-control" name="is_military" value="{{ old('is_military') }}">
                                            <option value="1" @if($process[$id]['customer']->is_military) selected @endif>True</option>
                                            <option value="0" @if(!$process[$id]['customer']->is_military) selected @endif>False</option>
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
                                        <select id="is_beard" class="form-control" name="is_beard" value="{{ old('is_beard') }}">
                                            <option value="1" @if($process[$id]['customer']->is_beard) selected @endif>True</option>
                                            <option value="0" @if(!$process[$id]['customer']->is_beard) selected @endif>False</option>
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
                                        <select id="next_reminder" class="form-control" name="next_reminder">
                                            <option value="1">1 Week</option>
                                            <option value="2">2 Week</option>
                                            <option value="3">3 Week</option>
                                            <option value="4">4 Week</option>
                                            <option value="5">5 Week</option>
                                            <option value="6">6 Week</option>
                                            <option value="7">7 Week</option>
                                            <option value="8">8 Week</option>
                                            <option value="9">9 Week</option>
                                            <option value="10">10 Week</option>
                                            <option value="11">11 Week</option>
                                            <option value="12">12 Week</option>
                                        </select>

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

                <div class="col-md-8">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Services & Products</h3>
                        </div>
                        <div class="panel-body">
                            <div class="">
                                <input id="start_date_time" type="hidden" class="form-control" name="start_date_time" value="{{$process[$id]['start_date_time']}}">

                                <div class="form-group">
                                    <label for="services" class="control-label">Services</label>
                                    <div class="col-md-12 row">
                                        @foreach($process[$id]['services'] as $key => $value)
                                            <div class="col-md-9">
                                                <input id="service[{{$key}}][checked]" type="checkbox" name="service[{{$key}}][checked]" checked>
                                                <label style="font-weight: normal !important;" for="service[{{$key}}][checked]" class="control-label">{{$value['name']}} (Duration: {{$value['duration']}})</label>
                                            </div>
                                            <div class="col-md-1">
                                                <h5>&pound</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <input onkeypress="retotal(-this.value)" onkeyup="retotal(this.value)" id="service[{{$key}}][actual_cost]" name="service[{{$key}}][actual_cost]" type="text" class="form-control" value="{{$value['cost']}}">
                                            </div>
                                        @endforeach
                                        <br/><br/><br/>
                                        <div class="col-md-9">
                                            <input id="other_checked" type="checkbox" name="other_checked">
                                            <label style="font-weight: normal !important;" for="other_checked" class="control-label">Other Services</label>
                                            <input id="other_service" name="other_service" type="text" class="form-control">
                                        </div>
                                        <div class="col-md-1">
                                            <h5>&pound</h5>
                                        </div>
                                        <div class="col-md-2">
                                            <input onkeypress="retotal(-this.value)" onkeyup="retotal(this.value)" id="other_cost" name="other_cost" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="products" class="control-label">Products</label>
                                    <div class="col-md-12 row">
                                        <div class="col-md-6">
                                            <select id="products" class="form-control" name="products">
                                                @foreach($products as $product)
                                                    <option name="{{$product->name}}" value="{{$product->id}}">{{$product->name}} (&pound {{$product->cost}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <h5>
                                                <span style="cursor: pointer" onclick="product_quantity('dec')"><i class="fa fa-minus-circle"></i></span>
                                                <span id="product_quantity">1</span>
                                                <span style="cursor: pointer" onclick="product_quantity('inc')"><i class="fa fa-plus-circle"></i></span>
                                            </h5>
                                        </div>
                                        <div class="col-md-2">
                                            <span onclick="add_product()" class="btn btn-sm btn-primary">Add Product</span>
                                        </div>
                                        <br/><br/><br/>
                                        <div id="products_container">

                                        </div>
                                    </div>
                                </div>

                                <hr/>

                                <label class="col-md-12">
                                    <div class="col-md-10">Total</div>
                                    <div class="col-md-2 pull-right">&pound  <span id="total">0.00</span></div>
                                </label>
                            </div>

                            <div class="">
                                <button id="create_booking" type="submit" class="col-md-12  btn btn-success">
                                    Process Booking
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
        $(function (){
            @foreach($process[$id]['services'] as $key => $value)
                 retotal({{$value['cost']}});
            @endforeach
        });

        function product_quantity(type) {
            var value = $('#product_quantity').html();
            if(type == 'inc') {
                document.getElementById('product_quantity').innerHTML = parseInt(value)+1;
            } else {
                if(parseInt(value) >= 2)
                    document.getElementById('product_quantity').innerHTML = parseInt(value)-1;
                else
                    alert('You may not have less than 1 product');
            }
        }

        function retotal(cost) {
            if(!isNaN(cost) && cost != '') {
                cost = parseFloat($('#total').html(),2)+parseFloat(cost,2);
                $('#total').html(cost);
            }
        }

        function remove_product(id) {
            $("#product_"+id).html('');
        }

        var products = [];
        function add_product() {
            if(products.indexOf($('#products').val()) == -1) {
                products.push($('#products').val());
                console.log(products);
                $.ajax({
                    url: '/product/'+$('#products').val(),
                    type: 'get',
                    dataType: 'json',
                    success: function(data) {
                        var cost = parseInt($('#product_quantity').html())*data.cost;
                        var content = '<div id="product_'+data.id+'"><div class="col-md-9">'
                                +'<span style="cursor:pointer" onclick="(remove_product('+data.id+'))"><i class="fa fa-close"></i></span>&nbsp;&nbsp;<span class="control-label">'+data.name+' ('+$('#product_quantity').html()+')</span>'
                                +'</div>'
                                +'<div class="col-md-1">'
                                +'<h5>&pound</h5></div><div class="col-md-2">'
                                +'<input type="hidden" name="product['+data.id+'][quantity]" id="product['+data.id+'][quantity]" value="'+$('#product_quantity').html()+'">'
                                +'<input onkeypress="retotal(-this.value)" onkeyup="retotal(this.value)" name="product['+data.id+'][actual_cost]" id="product['+data.id+'][actual_cost]" type="text" class="form-control" value="'+cost+'">'
                                +'</div></div>';
                        $('#products_container').append(content);

                        retotal(cost);
                    }
                });
            } else {
                alert('This product is already been added');
            }
        }
    </script>
@endsection