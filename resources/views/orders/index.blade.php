@extends('layouts.app')

@section('content')
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Orders <small style="color: red;">
                @if(isset($type))
                  @if($type == 'pending')
                    List of Orders Place or Filled Only !!
                  @else  
                    Complete List of Orders
                  @endif  
                @endif
                </small></h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-16 col-sm-16 col-xs-16">
                <div class="x_panel">
                  @include('orders/search')
                  <div class="x_content">
                    @if(count($orders) > 0) 
                      {!! $orders->appends(Input::except('page'))->links() !!} 
                    @endif
                    <table id="datatable-orders" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>&nbsp;</th>
                          <th>Order No.</th>
                          <th>Customer Name</th>
                          <th>Order Date</th>
                          <th>Exp Delivery Date</th>
                          <th>Delivered Date</th>
                          <th>Sale Person</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($orders as $order)
                        <tr>
                          @if($order->order_channel == 'fws') 
                          <td><a href='{{ url("/fws_detail/$order->order_ref") }}'>view</a></td>
                          @else
                          <td><a target="_blank" href='{{ url("/hawavee_orders/$order->order_no") }}'>view</a></td>
                          @endif
                          <td>@if($order->order_channel == 'fws') {{ $order->order_ref }} @else {{ $order->order_no }} @endif</td>
                          <td>@if($order->customer){{ $order->customer->customer_name }}@endif</td>
                          <td class='date'>{{ $order->order_date }}</td>
                          <td class='date'>{{ $order->expected_delivery_date }}</td>
                          <td class='date'>{{ $order->delivered_date }}</td>
                          <td>{{ $order->sale_person }}</td>
                          <td>{{ $order->order_status }}</td>
                        </tr>
                      @endforeach 
                      </tbody>
                    </table>
                    @if(count($orders) > 0) 
                      {!! $orders->appends(Input::except('page'))->links() !!} 
                    @endif
          
                  </div>
                </div>
              </div>
            </div>         
</div>
@endsection