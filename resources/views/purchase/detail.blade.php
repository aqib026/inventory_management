

@extends('layouts.app')

@section('content')
<div class="">
	<div class="page-title">
		<div class="title_left">
			<h3>Purchased Orders {{ $order->p_order_no }}</h3>
		</div>
	</div>
	<div class="clearfix"></div>
	<form action='{{ url("/receive_porder/$order->p_order_no")}}' method="post">
	{!! csrf_field() !!}
	<div class="row">

		<div class="col-md-4 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">

					<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
						<tr>
							<th>Order No.</th>
							<td>{{ $order->p_order_no }}</td>
						</tr>
						<tr>
							<th>Supplier</th>
							<td>{{ $order->supplier->supplier_name }}</td>
						</tr>
						<tr>
							<th>Order Date</th>
							<td>{{ dateformat($order->p_order_date) }}</td>
						</tr>
						<tr>
							<th>Prepaired By</th>
							<td>{{ $order->prepaired_by }}</td>
						</tr>
						<tr>
							<th>Authorize By</th>
							<td>{{ $order->authorized_by }}</td>
						</tr>
						<tr>
							<th>Arrival Date</th>
							<td>{{ dateformat($order->arrival_date) }}</td>
						</tr>
						<tr>
							<th>Received On</th>
							<td>@if($order->received_on != '0000-00-00'){{ dateformat($order->received_on) }} @endif</td>
						</tr>
						<tr>
							<th>Status</th>
							<td>
							@if($order->order_status == 'placed' && Auth::user()->can('edit_purchase_order'))
								<input type="submit" onclick="return confirm('Are you sure you want to mark this order as recevied in Warehouse');" class="btn btn-success" value="Marked as Received in Warehouse">
							@elseif($order->order_status == 'marked' && Entrust::hasRole('owner'))
								<input type="submit" onclick="return confirm('Are you sure you want to mark this order as recevied');" class="btn btn-success" value="Receive Order">
							@else
								{{$order->order_status}}
							@endif
							</td>
						</tr>
						</table>   
				</div>
			</div>
		</div>


		<div class="col-md-8 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">

					<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
						<tr>
							<th>&nbsp;</th>
							<th>Design Code</th>
							<th>Color</th>
							<th>Size</th>
							<th>Required Qty</th>
							<th>Received Qty</th>
							<th>Purchase Price</th>
							<th>Other Price</th>
						</tr>	

						@foreach($order->order_list as $item)
						<tr>
							<td><span class="glyphicon glyphicon-remove" data-itemid=""></span></td>
							<td>{{$item->design_code}}</td>
							<td>{{$item->color}}</td>
							<td>{{$item->size}}</td>
							<td>{{$item->order_qty}}</td>
							<td>
								@if($item->received_qty == 0)
								<input type="text" name="recevied[{{$item->entry_id}}]" value="{{$item->order_qty}}" />
								@else
								<input type="text" name="recevied[{{$item->entry_id}}]" value="{{$item->received_qty}}" />
								@endif
							</td>
							<td>{{$item->cost_price}}</td>
							<td>{{$item->other_cost}}</td>
						</tr>			
						@endforeach
					</table>
				</div>
			</div>
		</div>
	</div>        
	</form> 
</div>
@endsection
