@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12" >
                <h1>Index</h1>
                <h4>Product</h4>
                <hr/>
            </div>
            <h5><a href="{{ url('/product/create') }}">Create New</a></h5>
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Cost</th>
                    <th></th>
                </tr>
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->name}}</td>
                        <td>{{$product->cost}}</td>
                        <td>
                            <a href="{{ url('/product/'.$product->id.'/edit') }}">Edit</a>
                            &nbsp;|&nbsp;
                            <a href="#" onclick="detail_product({{$product->id}})">Details</a>
                            &nbsp;|&nbsp;
                            <a href="#" onclick="delete_product({{$product->id}})">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="details" tabindex="-1" role="dialog" aria-labelledby="product_details" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Product Details</h4>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        function delete_product(id){
            if(confirm("Are you sure that you want to delete?")){
                $.ajax({
                    url: '/product/'+id,
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

        function detail_product(id){
            $('#details').modal('show');

            $.ajax({
                url: '/product/'+id,
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    $('#name').html(data.name);
                    $('#cost').html(data.cost);
                }
            });
        }
    </script>
@endsection