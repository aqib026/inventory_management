@extends('layouts.app')

@section('content')
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Customers <small>Manage Customers</small></h3>
              </div>

              <div class="title_right">
                @if(Auth::user()->can('add_customer'))
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <a href=" {{url('/customers/create')}} " class="btn btn-success">ADD NEW</a>
                  @if($active == 'yes')
                    <a href=" {{url('/nonactive')}} " class="btn btn-info">Non Active</a>
                  @else
                    <a href=" {{url('/customers')}} " class="btn btn-info">Active</a>
                  @endif 
                    <a href="javascript:void(0)" class="btn btn-danger">{{ $country }}</a>
                </div>
                @endif
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                <div class="x_title">
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
                      <option value="user">Sale Person</option>
                    </select>
                    </div>

                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <input type="submit" value="Search" class="btn btn-success">
                      <a href="{{ url('/customers') }}" class="btn btn-info">Reset</a>
                    </div>
                  </form>
                </div>
                  <div class="x_content">
                  {!! $customers->appends(Input::except('page'))->links() !!}
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Account</th>
                          <th>Status</th>
                          <th>Customer ID</th>
                          <th>Name</th>
                          <th>Business Name</th>
                          <th>Sale Person</th>
                          <th>VAT</th>
                          <th>Options</th>
                        </tr>
                      </thead>
                      <tbody>

                      @foreach ($customers as $key => $c)
                        <tr>
                          <td><a href='{{ url("/customers/$c->customer_id") }}'>view</a></td>
                          <td>
                            @if($c->acc_code == '' || $c->acc_code == 0) 
                              @if(Auth::user()->can('create_account'))
                              <a href='{{ url("/generate_code/$c->customer_id") }}' onclick="return confirm('You sure you want to create the account?');">Create Account</a> 
                              @endif
                            @else
                              @if(Auth::user()->can('view_account'))
                              <a href='{{ url("/accounts/$c->customer_id") }}'>Account</a>
                              @endif
                          @endif
                          </td>
                          <td>@if($c->active == 1) Active @else Not Active @endif</td>
                          <td>{{ $c->customer_id }}</td>
                          <td>{{ $c->customer_name }} {{ $c->middle_name }} {{ $c->last_name }}</td>
                          <td>{{ $c->business_name }}</td>
                          <td>{{ $c->user }}</td>
                          <td>@if($c->vat == 1) Yes @else No @endif</td>
                          <td>
                          <a href='{{ url("/customers/$c->customer_id/edit") }}'><span class="glyphicon glyphicon-pencil"></span></a>
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>
                  {!! $customers->appends(Input::except('page'))->links() !!}
          
          
                  </div>
                </div>
              </div>
            </div>         
</div>
@endsection
