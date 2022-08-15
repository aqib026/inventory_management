@extends('layouts.app')

@section('content')
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Purchased Orders List</h3>
              </div>

            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">

                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>&nbsp;</th>
                          <th>Order No.</th>
                          <th>Supplier</th>
                          <th>Order Date</th>
                          <th>Exp Receiving Date</th>
                          <th>Received On</th>
                          <th>Prepared By</th>
                          <th>Authorized By</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($purchase_orders as $order)
                        <tr>
                          <td><a href='{{ url("/purchase_detail/$order->p_order_no") }}'>view</a></td>
                          <td>{{ $order->p_order_no }}</td>
                          <td>{{ $order->supplier_id}}</td>
                          <td>{{ $order->p_order_date }}</td>
                          <td>{{ $order->expected_receiving_date }}</td>
                          <td>{{ $order->received_on }}</td>
                          <td>{{ $order->prepaired_by }}</td>
                          <td>{{ $order->authorized_by }}</td>
                          <td>{{ $order->order_status }}</td>
                        </tr>
                        
                      @endforeach 
                      </tbody>
                    </table>
          
          
                  </div>
                </div>
              </div>
            </div>         
</div>
@endsection
