@extends('layouts.app')

@section('content')
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Sales Section <small></small></h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">

                 <form action="" method="get" class="form-horizontal form-label-left">
                    
                    <label class="control-label col-md-1 col-sm-3 col-xs-12">Filter</label>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" name="search" value="{{ $search }}" required autofocus>
                    </div>

                    <label class="control-label col-md-1 col-sm-3 col-xs-12">Filter By</label>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                    <select name="filter_by" class="form-control" >
                      <option value="customer_name">Customer Name</option>
                      <option value="customer_id">Customer Id</option>
                    </select>
                    </div>

                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <input type="submit" value="Search" class="btn btn-success">
                      <a href="{{ url('/sales') }}" class="btn btn-info">Reset</a>
                    </div>
                  </form> 
                               
                <form method="post" action="{{ url('/select_customer') }}">
                {!! csrf_field() !!}
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Select a customer to place order !</h2>
                    <p> <input type="submit" value="Buy Now !" name="place_order" class="btn btn-warning"></p>
                    @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="table-responsive">
                  {!! $customers->appends(Input::except('page'))->links() !!}
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>&nbsp;</th>
                          <th>&nbsp;</th>
                          <th>ID</th>
                          <th>Customer Name</th>
                          <th>Business Name</th>
                          <th>Post Code</th>
                          <th>User</th>
                          <th width="150px;">Note</th>
                        </tr>
                      </thead>
                      <tbody>
                       @if($customers)
                        @foreach($customers as $customer)
                          <tr>
                            <td>&nbsp;&nbsp;&nbsp;<input type="radio" name="customer_id" value="{{ $customer->customer_id}}">&nbsp;&nbsp;&nbsp;</td>
                            <td><a href='{{ url("/accounts/$customer->customer_id") }}'>Account</td>
                            <td>{{ $customer->customer_id}}</td>
                            <td>{{ $customer->customer_name}}</td>
                            <td>{{ $customer->business_name}}</td>
                            <td>{{ $customer->postcode}}</td>
                            <td>{{ $customer->user}}</td>
                            <td>{{ $customer->note}}</td>
                          </tr>
                        @endforeach
                       @endif
                      </tbody>
                    </table>
          
                  {!! $customers->appends(Input::except('page'))->links() !!}
                  </div>
                  </div>
                </div>
                </form>
              </div>
            </div>         
</div>
@endsection
