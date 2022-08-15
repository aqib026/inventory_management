@extends('layouts.app')

@section('content')
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Pending Transactions<small></small></h3>
              </div>

              <div class="title_right">
                  <a href=" {{url('/received_payments')}} " style="float: right;" class="btn btn-success">Received Payments</a>
              </div>
            </div>
            <div class="clearfix"></div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
    	<div class="x_title">
    		<form action="" method="get" class="form-horizontal form-label-left">
                <label class="control-label col-md-2 col-sm-3 col-xs-12">Select Salesman</label>
                <div class="col-md-2 col-sm-6 col-xs-12">
                	<select name="user" id="user" class="form-control">
                		<option value="all">All</option>
                		@foreach($users as $u)
                			<option value="{{ $u->username }}">{{ $u->username }}</option>
                		@endforeach
                	</select>
                </div>   
                <div class="col-md-2 col-sm-6 col-xs-12">
                	<input type="submit" value="Update" class="btn btn-warning">
                </div> 			
    		</form>
    	</div>
    	<div class="x_content">
    		<table class="table table-striped table-bordered dt-responsive">
    			<tr>
    				<th>Receipt ID</th>
    				<th>Customer ID</th>
    				<th>Customer Name</th>
    				<th>Date</th>
    				<th>Description</th>
    				<th>Received By</th>
    				<th>Payment Mode</th>
    				<th>Amount</th>
    				<th>Status</th>
    				<th>Sale Person</th>    				 	 	 	 	 	 	 	 	 	 	 	
    			</tr>
    			@foreach($receipts as $r)
    				<tr>
    					<td>{{$r->receipt_id}}</td>
    					<td><a href='{{ url("/accounts/$r->customer_id")}}' target="_blank">{{$r->customer_id}}</a></td>
    					<td>{{$r->customer->customer_name}}</td>
    					<td>{{$r->date}}</td>
    					<td>{{$r->note}}</td>
    					<td>{{$r->received_by}}</td>
    					<td>{{$r->payment_mode}}</td>
    					<td>{{$r->amount}}</td>
    					<td><a href='{{ url("/receive_payment/$r->receipt_id")}}' onclick="return confirm('Are you sure you , have received this payment ?')">{{$r->status}}</a></td>
    					<td>{{$r->user}}</td>
    				</tr>
    			@endforeach
    		</table> 
    	</div>
    </div>
    </div>
  </div>
</div>
@endsection