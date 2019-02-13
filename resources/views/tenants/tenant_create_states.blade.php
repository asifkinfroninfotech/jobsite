<option value="">Select</option>
@foreach($data as $data)
@if(isset($option) && !empty($option))

<option value="{{$data->id}}">{{$data->name}}</option>
@else
<option value="{{$data->stateid}}">{{$data->name}}</option>
@endif

@endforeach