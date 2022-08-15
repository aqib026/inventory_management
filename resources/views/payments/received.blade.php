@extends('layouts.app')

@section('content')
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Received Transactions<small></small></h3>
              </div>

              <div class="title_right">
                  <a href=" {{url('/pending_payments')}} " style="float: right;" class="btn btn-success">Pending Payments</a>
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
            {!! $receipts->appends(Input::except('page'))->links() !!}
    		<table class="table table-striped table-bordered dt-responsive">
    			<tr>
    				<th>Receipt ID</th>
    				<th>Customer ID</th>
    				<th>Customer Name</th>
                    <th>Account</th>
    				<th>Date</th>
    				<th>Description</th>
    				<th>Received By</th>
    				<th>Payment Mode</th>
                    <th>Cleared</th>
    				<th>Amount</th>
                    <th>Mark</th>
    				<th>Status</th>
                    <th>Confirm By</th>
                    <th>Confirm Date</th>
    				<th>Sale Person</th>    				 	 	 	 	 	 	 	 	 	 	 	
    			</tr>
    			@foreach($receipts as $r)
    				<tr>
    					<td>{{$r->receipt_id}}</td>
    					<td><a href='{{ url("/accounts/$r->customer_id")}}' target="_blank">{{$r->customer_id}}</a></td>
    					<td>{{$r->customer->customer_name}}</td>
                        <td><a target="_blank" href='{{ url("/accounts/$r->customer_id") }}'>Account</a></td>
    					<td>{{ Carbon\Carbon::parse($r->date)->format('d M Y') }}</td>
    					<td>{{$r->note}}</td>
    					<td>{{$r->received_by}}</td>
    					<td>{{$r->pm_title()}}</td>
                        <td>@if($r->payment_mode == 'cp' && $r->cleared == 0) Not cleared {{ $r->cheque_due_date }} @elseif($r->payment_mode == 'cp' && $r->cleared == 1) cleared on {{ $r->cheque_due_date }}
                        @endif</td>
    					<td>{{$r->amount}}</td>
                        <td id="markunmark_{{$r->receipt_id}}" @if($r->mark == 1) class="makered"  @endif>
                        @if( Auth::user()->can('mark_unmark') )
                            @if($r->mark == 1) 
                                <a href="javascript:void(0)" onclick="markunmark({{$r->receipt_id}},0)"> Marked</a>   
                            @else  
                                <a href="javascript:void(0)" onclick="markunmark({{$r->receipt_id}},1)">ok</a> 
                            @endif
                        @else
                            @php echo ($r->mark == 1)?'marked':'ok'; @endphp
                        @endif    
                        </td>
    					<td><a href='{{ url("/receive_payment/$r->receipt_id")}}' onclick="return confirm('Are you sure you , have received this payment ?')">{{$r->status}}</a></td>
                        <td>{{$r->confirm_by }}</td>
                        <td>{{$r->confirm_date }}</td>
    					<td>{{$r->user}}</td>
    				</tr>
    			@endforeach
    		</table> 
            {!! $receipts->appends(Input::except('page'))->links() !!}
    	</div>
    </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    function markunmark(rid,m){
        if(m == 0){
            n = confirm('Are you sure you want to set status as OK');
        }else{
            n = confirm('Are you sure you want to set status as Marked');
        }
        if(n){
            $.ajax({
                type:'GET',
                url :"{{ url('/markunmark') }}",
                data:{rid:rid,m:m},
                success:function(response){
                    if(m == 0){
                       $("#markunmark_"+rid).removeClass('makered');
                       $("#markunmark_"+rid).html('<a href="javascript:void(0)" onclick="markunmark('+rid+',1)"> ok</a>');                       
                    }else{
                       $("#markunmark_"+rid).addClass('makered');
                       $("#markunmark_"+rid).html('<a href="javascript:void(0)" onclick="markunmark('+rid+',0)"> Marked</a>');
                    }                    
                }
            });
        }
    }
</script>
@endsection