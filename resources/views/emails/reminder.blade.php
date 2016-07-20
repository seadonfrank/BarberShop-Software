Hello {{$customer->name}},
<br/>
{{$customer->body}}
@if($customer->opt_out != "")
    <br/><br/>
    You may feel free to <a target="_blank" href="{{config('app.url')}}/{{$customer->opt_out}}">opt-out</a> of this E-mailer
@endif