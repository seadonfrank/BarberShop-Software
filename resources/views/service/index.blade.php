@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12" >
                <h1>Index</h1>
                <h4>Service</h4>
                <hr/>
            </div>
            <h5><a href="{{ url('/service/create') }}">Create New</a></h5>
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Cost</th>
                    <th>Duration</th>
                    <th></th>
                </tr>
                @foreach($services as $service)
                    <tr>
                        <td>{{$service->name}}</td>
                        <td>{{$service->cost}}</td>
                        <td>{{$service->duration}}</td>
                        <td>
                            <a href="{{ url('/service/'.$service->id.'/edit') }}">Edit</a>
                            &nbsp;|&nbsp;
                            <a href="#" onclick="detail_service({{$service->id}})">Details</a>
                            &nbsp;|&nbsp;
                            <a href="#" onclick="delete_service({{$service->id}})">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="details" tabindex="-1" role="dialog" aria-labelledby="service_details" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Service Details</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="name" class="col-md-4 control-label">Name:</label>
                            <p class="col-md-8" id="name"></p>
                        </div>
                        <div class="col-md-12">
                            <label for="cost" class="col-md-4 control-label">Cost:</label>
                            <p class="col-md-8" id="cost"></p>
                        </div>
                        <div class="col-md-12">
                            <label for="cost" class="col-md-4 control-label">Duration:</label>
                            <p class="col-md-8" id="duration"></p>
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
        function delete_service(id){
            if(confirm("Are you sure that you want to delete?")){
                $.ajax({
                    url: '/service/'+id,
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

        function detail_service(id){
            $('#details').modal('show');

            $.ajax({
                url: '/service/'+id,
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    $('#name').html(data.name);
                    $('#cost').html(data.cost);
                    $('#duration').html(data.duration);
                }
            });
        }
    </script>
@endsection