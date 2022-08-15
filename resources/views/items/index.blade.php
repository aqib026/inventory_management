@extends('layouts.app')

@section('content')
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Orders <small></small></h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Responsive example<small>Users</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      Responsive is an extension for DataTables that resolves that problem by optimising the table's layout for different screen sizes through the dynamic insertion and removal of columns from the table.
                    </p>
          
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>&nbsp;</th>
                          <th>Order No.</th>
                          <th>Customer Name</th>
                          <th>Order Date</th>
                          <th>Exp Delivery Date</th>
                          <th>Sale Person</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($orders as $order)
                        <tr>
                          <td><a href='{{ url("/hawavee_orders/$order->order_no") }}'>view</a></td>
                          <td>{{ base64_encode($order->order_no) }}</td>
                          <td>@if($order->customer){{ $order->customer->customer_name }}@endif</td>
                          <td>{{ $order->order_date }}</td>
                          <td>{{ $order->expected_delivery_date }}</td>
                          <td>{{ $order->sale_person }}</td>
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
