Your report filter:<br>
<b>Data Range</b>
 @if($details['range'] == '1') 15 Days 
 @elseif($details['range'] == '2') Last 30 Days 
 @elseif($details['range'] == '3') Last Month

@endif<br>
<b>Data Type:</b>
@if($details['type'] == '1') Local 
@elseif($details['type'] == '2') Incoming 
@elseif($details['type'] == '3') Outgoing
@elseif($details['type'] == '4') All 
@endif <br>
<b>Source</b>: $details['source']<br>
<b>Destination</b>: $details['destination']<br>
<b>Duration</b>: $details['duration']<br>


Call Report is ready to download. Please click here to download the report <a href="http://{{ $details['url'] }}/pdf/{{ $details['id'] }}/id">Download</a></h3>
