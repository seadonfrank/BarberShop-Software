Hi {{$data['customer']->name}},
<br/><br/>
Just a quick email - @if(isset($data['booking']))your last appointment at {{$data['business']['name']}} with {{App\User::find($data['booking']->user_id)->name}} was {{$data['NoOfWeeks']}}@if($data['NoOfWeeks'] == 1) Week @else Weeks @endif ago.@endif If you'd like to book an appointment please call us on:
<br/><br/>
{{$data['business']['contact_number']}}
<br/><br/>
Many thanks,
<br/><br/>
The {{$data['business']['name']}} Team
@if($data['customer']->opt_out != "")
    <br/><br/><br/>
    You may feel free to <a target="_blank" href="{{config('app.url')}}/{{$data['customer']->opt_out}}">opt-out</a> of this E-mailer
@endif