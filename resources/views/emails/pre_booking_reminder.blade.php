<?php
$start_date_time = new \DateTime($data['booking']['start_date_time']);
?>
Hi {{$data['booking']['customer']->name}},
<br/><br/>
Your appointment at {{$data['business']['name']}} is in {{$data['NoOfDays']}}@if($data['NoOfDays'] == 1) Day @else Days @endif time, and booked for:
<br/><br/>
{{date('Y-m-d', $start_date_time->getTimestamp())}} - {{date('H:i:s', $start_date_time->getTimestamp())}}
<br/><br/>
We look forward to seeing you, for more information or to change your booking, please call us on {{$data['business']['contact_number']}}.
<br/><br/>
Many thanks,
<br/><br/>
The {{$data['business']['name']}} Team