@php
 $activities_col=collect(json_decode($activities, true));
@endphp

@foreach($unique_activities as $u)

<div class="timed-activity">
    <div class="ta-date">
    <span>{{$u->onlydate}}</span>
    </div>
    <div class="ta-record-w">
            @php
            $current_acts=$activities_col->where('onlydate',$u->onlydate);
           @endphp
        
        @foreach($current_acts as $act)
        <div class="ta-record">
                <div class="ta-timestamp">
                  <strong>{{date('h:i A', strtotime($act['datetime']))}}</strong>
                </div>
                <div class="ta-activity">
                  {!! $act['action'] !!}
                </div>
              </div>
        @endforeach
    </div>
  </div>

@endforeach

