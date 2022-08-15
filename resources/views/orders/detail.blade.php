@extends('layouts.app')

@section('content')
<div class="">
            <div class="row">
              
              <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <div class="row">
                      @if(isset($previous))
                      <a href='{{ url("/hawavee_orders/$previous") }}' style="float: left;"><< Previous</a>
                      @endif
                      @if(isset($next))
                      <a href='{{ url("/hawavee_orders/$next") }}' style="float: right;">Next >></a>
                      @endif
                    </div>
                    
                    <h2>Hawavee Order # <strong>{{$order->order_no}}</strong> 
                    &nbsp;&nbsp;&nbsp;
                    <a href="javascript:void(0)" class="btn btn-warning">{{$order->order_status}}</a>
                   
                    </h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table class="table table-striped table-bordered dt-responsive nowrap">
                      @if( Auth::user()->can('view_customer') )
                      <tr>
                        <td>Customer Name</td>
                        @if(isset($order->customer))
                        <td>{{$order->customer->business_name}}</td>
                      </tr>
                      <tr>
                        <td>Customer ID</td>
                        <td>{{$order->customer->customer_id}}</td>
                      </tr>
                      <tr>
                        <td>VAT Customer</td>
                        <td>@if($order->customer->vat == 1) Yes @else No @endif</td>
                        @endif
                      </tr>
                      <tr>
                        <td>Sale Person</td>
                        <td>{{$order->sale_person}}</td>
                      </tr>
                      @endif
                      @if( $order->order_channel == 'old_hawavee_order')
                      <tr>
                        <td>Original Order</td>
                        <td><a target="_blank" href='{{ url("/hawavee_orders/$order->order_ref") }}'>Original Order {{ $order->order_ref }}</a></td>
                      </tr>
                      @endif
                      <tr>
                        <td>Order Date</td>
                        <td>{{$order->order_date}}</td>
                      </tr>
                      <tr>
                        <td>Exp delivery date</td>
                        <td>{{$order->expected_delivery_date}}</td>
                      </tr>
                      <tr>
                        <td>Status</td>
                        <td>{{$order->order_status}}</td>
                      </tr>
                      <tr>
                        <td>Note</td>
                        <td>
                        <form action="{{ url('/update_note')}}" method="post">
                          {!! csrf_field() !!}
                          <textarea type="text" name="note" required="" >{{$order->note}}</textarea>
                          <br /><br />
                          <input type="hidden" name="order_no" value="{{$order->order_no}}">
                          <input type="submit" name="update" class="btn btn-success btn-sm" value="Update Note">
                        </form>
                       </td>
                      </tr>
                    </table>
                </div>
              </div>
            </div>         
            
              <!-- ORDER DETAIL ORDER DETAIL ORDER DETAIL ORDER DETAIL --> 
              <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title" style="text-align: right;">
                  @if($order->order_status != 'canceled')
                    <a target="_blank" href='{{ url("/view_invoice/$order->order_no") }}'>Invoice</a> &nbsp; &nbsp;
                    <a target="_blank" href='{{ url("/summary/$order->order_no") }}'>Summary</a> &nbsp; &nbsp;
                    <a target="_blank" href='{{ url("/view_list/$order->order_no") }}'>Packing List</a> &nbsp; &nbsp;
                    @if( ($order->order_status == 'filled' || $order->order_status == 'dispatched' || $order->order_status == 'placed') && $order->invoice() == "")
                    <a href="javascript:void(0)" onclick="makeChangeable();">Click To Fill Order</a> &nbsp; &nbsp;
                    @endif
                    <a href='{{ url("/change_order_status/$order->order_no") }}' class="modal_link">Changed Status</a> &nbsp; &nbsp;
                    
                    
                    <div class="clearfix"></div>
                  @endif
                  </div>
                <form action="{{ url('/fill_order')}}" method="post">
                  {!! csrf_field() !!}
                  <div class="x_content">
                    <table class="table table-striped table-bordered dt-responsive nowrap">
                      <tr>
                        <th>Item No</th>
                        <th>Design Code</th>
                        <th>Size</th>
                        <th>Color</th>
                        @if( Auth::user()->can('unit_price') )
                        <th>Unit Price</th>
                        @endif
                        <th>Available in Store</th>
                        <th>Required Qty</th>
                        <th>Filled Qty</th>
                        <th>Ware Location</th>
                      </tr>
                        @if(count($order->line) > 0)
                          @foreach($order->line as $line)
                          <tr>
                            <td>{{$line->item_no}}</td>
                            <td>{{$line->design_code}}</td>
                            <td>{{$line->size}}</td>
                            <td>{{$line->color}}</td>
                            @if( Auth::user()->can('unit_price') )
                            <td>{{$line->charged_price}}</td>
                            @endif    
                            <td>hidden</td>
                            <td>{{$line->require_qty}}</td>
                            <td>
                              <input type="number" class="fillfields" readonly="" name="fill[{{$line->entry_id}}]" min="0" max="{{$line->require_qty}}" value="{{$line->filled_qty}}"> </td>
                            <td>{{$line->design_detail->wl}}</td>
                          </tr>
                          @endforeach
                        @endif
                    </table>
                    <p>
                      <input type="hidden" name="order_no" value="{{$order->order_no}}">
                      <input type="submit" value="Fill Order" class="btn btn-success btn-sm" id="fill_order" disabled="" />
                    </p>
                </div>
                </form>
              </div>
            </div>                 


</div>
</div>
<script type="text/javascript">
    function makeChangeable(){
    $('.fillfields').each(function(i, obj) {
      $(obj).attr('readonly',false);
    });      
    $('#fill_order').attr('disabled',false);
    }
</script>
@endsection