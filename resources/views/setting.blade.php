@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="col-md-10">Settings</h1>
            <br/>
            <table class="table">
                @if(count($settings)>0)
                    @foreach($settings as $setting)
                        <tr>
                            <td>
                                <h3>{{$setting->key}}</h3>
                                <span class="text-muted">{{$setting->help}}</span>
                            </td>
                            <td>
                                <h3></h3><br/>
                                <input id="{{$setting->id}}" class="col-md-2" type="{{$setting->type}}" value="{{$setting->value}}">
                            </td>
                            <td>
                                <h3></h3><br/>
                                <button onclick="save({{$setting->id}})" class="btn btn-success">Save</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>
                            <h4>No Settings Found</h4>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        function save(id){
            $.ajax({
                url: '/setting/'+id,
                type: 'post',
                dataType: 'json',
                data: 'data='+document.getElementById(id).value,
                success: function(data) {
                    if(data.response) {
                        location.reload();
                    } else {
                        alert("Unable to delete. Please try in some time.");
                    }
                }
            });
        }
    </script>
@endsection