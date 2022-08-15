@extends('layouts.app')

@section('title', 'Page Title')
@section('content')
<div class="">
            <div class="page-title">
                 <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-warning">
                      View the List of the New and OLD design codes <a href='{{ asset("/public/codes reset.pdf") }}' target="_blank">View File</a> 
                    </div>
                     <div class="alert alert-info">
                         <a target="_blank" href="{{ url('/ebay_getaccess') }}">Get Token From Ebay</a>
                     </div>
                 </div>
              {{-- <!--
              <div class="title_left">
                <h3>Items Quantity Information <small>Items need to purchase</small></h3>
              </div>

              <div class="title_right">

              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel"></div>
                <div class="x_content">
                  {!! $quantity_info->appends(Input::except('page'))->links() !!}
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Design Code</th>
                          <th>Pending Orders Qty</th>
                          <th>Available in Warehouse</th>
                          <th>Need to Buy</th>
                          <th>Options</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($quantity_info as $i)
                        @php 
                        $info = \App\ItemSizeColor::get_design_qty($i->design_code);
                        @endphp
                        <tr>
                          <td></td>
                          <td>{{$i->design_code}}</td>
                          <td>{{$i->rqty}}</td>
                          <td>{{$info[0]}}</td>
                          <td>{{$info[1]}}</td>
                          <td> <a href="" class="btn btn-info">View Detail</a> </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>  
                  {!! $quantity_info->appends(Input::except('page'))->links() !!}
                </div>
              </div> -->--}}
            </div>  

</div>

@endsection