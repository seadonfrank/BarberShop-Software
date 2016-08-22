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
                                <input id="{{$setting->id}}" class="col-md-8" type="{{$setting->type}}" @if($setting->type=='checkbox' && $setting->value=='1') checked @endif value="{{$setting->value}}">
                            </td>
                            <td>
                                <h3></h3><br/>
                                <button onclick="save('{{$setting->id}}', '{{$setting->type}}')" class="btn btn-success">Save</button>
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
        function save(id, type){
            var value = "";
            if(type == "checkbox"){
                value = document.getElementById(id).checked?"1":"0"
            } else{
                value = document.getElementById(id).value
            }
            $.ajax({
                url: '/setting/'+id,
                type: 'post',
                dataType: 'json',
                data: 'data='+value,
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