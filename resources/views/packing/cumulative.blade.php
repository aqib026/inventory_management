@extends('layouts.blank')

@section('content')
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Cumulative Packing List  <small>@php date('d-M-Y') @endphp</small></h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <a href="javascript:void(0)"  class="olist">Orders List :</a>
                    @foreach($orders as $o)
                      <a class="olist" href='{{ url("/view_list/$o->order_no")}}'>Order no. {{$o->order_no}} </a>
                    @endforeach
                    -
                  </div>
                  <div class="x_content">
                    <table class="table">
                    @php $dc1 = '' @endphp
                    @foreach($cumulative_elo as $o)
                      @php
                          $isc = \App\ItemSizeColor::where('item_sc_code',$o->ino)->first();
                          $item_no = $o->ino;
                          $dc      = $o->dc;
                          $size    = $o->s;
                          $color   = $o->c;
                          $req_qty = $o->rq;
                          $aqty    = $isc->available_in_warehouse;

                      $dcorders = \App\Orderline::select( \DB::raw('sum(order_line.require_qty) rq'),\DB::raw('orders.order_no ono'))->join('orders','order_line.order_no', 'orders.order_no')->where('design_code',$o->dc)->where('orders.order_status','placed')->groupBy('orders.order_no')->get();
                      $item = \App\Item::where('design_code',$o->dc)->first();

                      if($aqty < $req_qty){
                        $bgrd = '#fa481e';
                      }else if($aqty < $req_qty + 10){
                        $bgrd = '#fa9a1e';
                      }else if($aqty < $req_qty + 20){
                        $bgrd = '#f2fa1e';
                      }else{
                        $bgrd = '';
                      }
                      @endphp
                      @if($dc1 != $dc)
                        @php $dc1 = $dc @endphp

                        <tr>
                          <th colspan="2">
                              {{$dc}} <br />
                              @if($item->cover_image)
                                @php $img = $item->cover_image->image @endphp
                                <img src=' {{ url("public/images/thumb/$img")}} ' />
                              @endif
                          </th>
                          <th colspan="4" style="text-align: center;"> 
                              {{ $item->category }} {{ $item->style }}<br />
                                @foreach($dcorders as $dco)
                                  <a href='{{ url("/view_list/$dco->ono")}}'>{{ $dco->ono }}</a> {{ $dco->rq }} <br />
                                @endforeach
                          </th>
                          <th>{{ $item->wl }}</th>
                        </tr>
                                    
                     <tr>
                       <td>Item No</td>
                       <td>Design Code</td>
                       <td>Size</td>
                       <td>Color</td>
                       <td>Available Qty</td>
                       <td>Req Qty</td>
                     </tr>   
                     @endif
                        @php $isc = \App\ItemSizeColor::where('item_sc_code',$dco->item_no)->first() @endphp
                        <tr>
                          <td>{{ $item_no }}</td>
                          <td>{{ $dc }}</td>
                          <td>{{ $size }}</td>
                          <td>{{ $color }}</td>
                          <td style="background-color: {{$bgrd}}">{{ $aqty }}</td>
                          <td>{{ $req_qty }}</td>
                        </tr>
                      
                    @endforeach
                    </table>
                  </div>
                </div>
              </div>
            </div>         
</div>
@endsection

<style type="text/css">
  .olist{
    width: 125px; float: left;
  }
</style>