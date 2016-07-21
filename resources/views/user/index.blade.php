@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12" >
                <h1>Index</h1>
                <h4>User</h4>
                <hr/>
            </div>
            <h5><a href="{{ url('/user/create') }}">Create New</a></h5>
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>IsAdmin</th>
                    <th></th>
                </tr>
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>@if($user->isadmin) Yes @else No @endif</td>
                        <td>
                            <a href="{{ url('/user/'.$user->id.'/edit') }}">Edit</a>
                            &nbsp;|&nbsp;
                            <a href="#" onclick="detail_user({{$user->id}})">Details</a>
                            &nbsp;|&nbsp;
                            <a href="#" onclick="delete_user({{$user->id}})">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="details" tabindex="-1" role="dialog" aria-labelledby="user_details" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">User Details</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="name" class="col-md-4 control-label">Name:</label>
                            <p class="col-md-8" id="name"></p>
                        </div>
                        <div class="col-md-12">
                            <label for="email" class="col-md-4 control-label">Email:</label>
                            <p class="col-md-8" id="email"></p>
                        </div>
                        <div class="col-md-12">
                            <label for="isadmin" class="col-md-4 control-label">IsAdmin:</label>
                            <p class="col-md-8" id="isadmin"></p>
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
        function delete_user(id){
            if(confirm("Are you sure that you want to delete?")){
                $.ajax({
                    url: '/user/'+id,
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

        function detail_user(id){
            $('#details').modal('show');

            $.ajax({
                url: '/user/'+id,
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    $('#name').html(data.name);
                    $('#email').html(data.email);
                    $('#isadmin').html((data.isadmin == 1) ? "Yes" : "No");
                }
            });
        }
    </script>
@endsection