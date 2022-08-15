<form id="demo-form2" action="{{ url('/makepurchase') }}" method="post" data-parsley-validate class="form-horizontal form-label-left">
 {!! csrf_field() !!}
<div class="x_panel">
	<div class="x_title">Design Code Price and Location
	<input type="submit" id="place_order" value="Place Order Now!" class="btn btn-success pull-right">
	<input type="hidden" name="place_order_id" value="{{ $purchase_order->p_order_no }}" >
	</div>
<table class="table">
	<tr>
		<th>Design Code</th>
		<th>Purchase Price</th>
		<th>Other Charges</th>
		<th>Weight</th>
		<th>Wharehouse Location</th>
		<th>Images</th>
	</tr>	

<?php $arr = array(); ?>

@foreach($purchase_order->order_list as $item)
	@if( !isset($arr[$item->design_code]) )
		<?php $arr[$item->design_code] = 1; ?>
	<tr>
		<td>{{$item->design_code}}</td>
		<td><input type="text" class="form-control" name="cost_price[{{$item->design_code}}]" required="required" style="width: 75px;"></td>
		<td><input type="text" class="form-control" name="other_cost[{{$item->design_code}}]" required="required" style="width: 75px;"></td>
		<td>{{$item->item_detail->weight}}</td>
		<td>{{$item->item_detail->wl}}</td>
		<td>images</td>
	</tr>			
	@endif
@endforeach

</table>
</div>
<div class="x_panel">
	<div class="x_title">Detail of Purchase Items</div>
<table class="table">
	<tr>
		<th>&nbsp;</th>
		<th>Design Code</th>
		<th>Color</th>
		<th>Size</th>
		<th>Required Qty</th>
		<th>Received Qty</th>
		<th>Purchase Price</th>
		<th>Other Price</th>
		<th>Weight</th>
	</tr>	

@foreach($purchase_order->order_list as $item)
	<tr>
		<td><span class="glyphicon glyphicon-remove" data-itemid="{{ $item->entry_id }}"></span></td>
		<td>{{$item->design_code}}</td>
		<td>{{$item->color}}</td>
		<td>{{$item->size}}</td>
		<td>{{$item->order_qty}}</td>
		<td>{{$item->received_qty}}</td>
		<td>{{$item->cost_price}}</td>
		<td>{{$item->other_cost}}</td>
		<td>{{$item->weight}}</td>
	</tr>			
@endforeach
</table>
</div>
</form>