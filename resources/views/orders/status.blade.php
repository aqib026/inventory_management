<div class="modal-header">
	<h4>Order # {{$order->order_no}}</h4>
</div>
<div class="modal-body">
	<form action="{{ url('update_order_status') }}" onsubmit="return confirm('Are you sure you want to change the status?')" method="post">
	{!! csrf_field() !!}
	<input type="hidden" name="order_no" value="{{ $order->order_no }}">
	<p><strong> Current Status : {{$order->order_status }}</strong></p>
	<p><strong> Change Status to :</strong> 
	<select name="status" class="form-control" required="">
		<option value="dispatched">Dispatched</option>
		<option value="delivered">Delivered</option>
		<option value="canceled">Canceled</option>
	</select></p>
	<p><strong> Change Status to :</strong> 
	@php( $m = date('M') ) @php( $y = date('Y') )
	@php( $d = date('d') )
	<select name="month">
		<option value="{{$m}}">{{$m}}</option>
		<option value="1">Jan</option>
		<option value="2">Feb</option>
		<option value="3">Mar</option>
		<option value="4">Apr</option>
		<option value="5">May</option>
		<option value="6">Jun</option>
		<option value="7">July</option>
		<option value="8">Aug</option>
		<option value="9">Sep</option>
		<option value="10">Oct</option>
		<option value="11">Nov</option>
		<option value="12">Dec</option>
	</select> - 
	<select name="day">
		<option value="{{$d}}">{{$d}}</option>
		@php( $d = 1)
		@while($d < 32)
			<option value="{{$d}}">{{$d}}</option>
			@php( $d++)
		@endwhile
	</select> - 
	<select name="year">
		<option value="{{$y}}">{{$y}}</option>
		@php( $d = 2018)
		@while($d < 2025)
			<option value="{{$d}}">{{$d}}</option>
			@php( $d++)
		@endwhile
	</select>
	</p>	
	<p><input type="submit" value="Update Status" name="" class="btn btn-default"></p>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>