@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12" >
                <h1>Index</h1>
                <h4 >Customer</h4>
                <hr/>
            </div>
            <h5><a href="{{ url('/customer/create') }}">Create New</a></h5>
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>EmailAddress</th>
                    <th>PhoneNumbers</th>
                    <th>SendReminders</th>
                    <th>IsStudent</th>
                    <th>IsChild</th>
                    <th>IsMilitary</th>
                    <th>hasBeard</th>
                    <th>NextReminder</th>
                    <th></th>
                </tr>
                @foreach($customers as $customer)
                    <tr>
                        <form class="form-horizontal" id="{{$customer->id}}" role="form" method="post" action="{{ url('/customer/'.$customer->id) }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="put" />
                            <td>{{$customer->name}}</td>
                            <td>{{$customer->email_address}}</td>
                            <td>{{$customer->phone_number}}</td>
                            <td>
                                <input type="checkbox" class="checkbox" name="send_reminders" @if($customer->send_reminders) checked @endif>
                            </td>
                            <td>
                                <select class="form-control" name="is_student">
                                    <option value="1" @if($customer->is_student) selected @endif>True</option>
                                    <option value="0" @if(!$customer->is_student) selected @endif>False</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control" name="is_child">
                                    <option value="1" @if($customer->is_child) selected @endif>True</option>
                                    <option value="0" @if(!$customer->is_child) selected @endif>False</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control" name="is_military">
                                    <option value="1" @if($customer->is_military) selected @endif>True</option>
                                    <option value="0" @if(!$customer->is_military) selected @endif>False</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control" name="is_beard">
                                    <option value="1" @if($customer->is_beard) selected @endif>True</option>
                                    <option value="0" @if(!$customer->is_beard) selected @endif>False</option>
                                </select>
                            </td>
                            <td>{{$customer->next_reminder}}</td>
                            <td>
                                <a href="{{url('/customer/'.$customer->id.'/edit')}}">Edit</a>
                                &nbsp;|&nbsp;
                                <a href="#" onclick="detail_customer({{$customer->id}})">Details</a>
                                &nbsp;|&nbsp;
                                <a href="#" onclick="delete_customer({{$customer->id}})">Delete</a>
                            </td>
                        </form>
                    </tr>
                @endforeach

            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="details" tabindex="-1" role="dialog" aria-labelledby="customer_details" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Customer Details</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="name" class="col-md-4 control-label">Name:</label>
                            <p class="col-md-8" id="name"></p>
                        </div>
                        <div class="col-md-12">
                            <label for="email_address" class="col-md-4 control-label">EmailAddress:</label>
                            <p class="col-md-8" id="email_address"></p>
                        </div>
                        <div class="col-md-12">
                            <label for="phone_number" class="col-md-4 control-label">PhoneNumber:</label>
                            <p class="col-md-8" id="phone_number"></p>
                        </div>
                        <div class="col-md-12">
                            <label for="send_reminders" class="col-md-4 control-label">SendReminders:</label>
                            <p class="col-md-8" id="send_reminders"></p>
                        </div>
                        <div class="col-md-12">
                            <label for="is_student" class="col-md-4 control-label">IsStudent:</label>
                            <p class="col-md-8" id="is_student"></p>
                        </div>
                        <div class="col-md-12">
                            <label for="is_child" class="col-md-4 control-label">IsChild:</label>
                            <p class="col-md-8" id="is_child"></p>
                        </div>
                        <div class="col-md-12">
                            <label for="is_military" class="col-md-4 control-label">IsMilitary:</label>
                            <p class="col-md-8" id="is_military"></p>
                        </div>
                        <div class="col-md-12">
                            <label for="is_beard" class="col-md-4 control-label">HasBeard:</label>
                            <p class="col-md-8" id="is_beard"></p>
                        </div>
                        <div class="col-md-12">
                            <label for="next_reminder" class="col-md-4 control-label">NextReminder:</label>
                            <p class="col-md-8" id="next_reminder"></p>
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
        function delete_customer(id){
            if(confirm("Are you sure that you want to delete?")){
                $.ajax({
                    url: '/customer/'+id,
                    type: 'delete',
                    dataType: 'json',
                        success: function(data) {
                        if(data.response) {
                            location.reload();
                        } else {
                            alert("Unable to delete. Please try in some time.");
                        }
                    }
                });
            }
        }

        function detail_customer(id){
            $('#details').modal('show');

            $.ajax({
                url: '/customer/'+id,
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
        }
    </script>
@endsection