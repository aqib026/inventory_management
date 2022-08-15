@extends('layouts.blank')

@section('content')
    <div class="col-md-1">&nbsp;</div>
    <div class="col-md-9">
    <div class="col-md-12" style="text-align: center;">
      <h4> @if($c->vat == 1) GFL Account @else B2S Account @endif </h4>
    </div>

    <div class="col-md-12">
      <p><b>Total Transactions : </b>
        {!! count($c->voucher_list()) !!}
      </p>
      <p><b>Account Title:</b>&nbsp;&nbsp;&nbsp; {{ $c->account_detail()->acc_title }}</p>
      <p><b>Account No:</b>&nbsp;&nbsp;&nbsp;{{ $c->acc_code }}</p>      
    </div>
    <div class="col-md-12"><hr /></div>

    <div class="col-md-12">
      <table class="table table-striped table-bordered dt-responsive nowrap">
        <tr>
          <th>&nbsp;</th>
          <th>Invoice</th>
          <th>Date</th>
          <th>Description</th>
          <th>Post Ref</th>
          <th>Invoice Paid/Unpaid</th>
          <th>Sales (dr) </th>
          <th>Payments (cr) </th>
          <th>Balance</th>
        </tr> 
          @php( $vat_sum = 0 )
          @php( $balance = 0 )
          @foreach($c->voucher_list() as $vd)
          @php(   $vat = $c->get_invoice($vd->voucher->order_id)['vat']  )
          @php( $vat_sum = $vat+$vat_sum )
        @if($c->vat == 0)
          @php( $balance = $balance + ($vd->dr+$vat) - $vd->cr )
        @else
          @php( $balance = $balance + ($vd->dr) - $vd->cr )
        @endif
            <tr>
              <td>@if($vd->voucher && $vd->voucher->order) {{$vd->voucher->order->order_no}} @endif</td>
              <td><a href='{{url("/voucher_details/$vd->voucher_id/$c->vat")}}' class="modal_link">detail</a></td>
              <td>@if($vd->voucher && $vd->voucher->order)
                  @php( $orderid = $vd->voucher->order->order_no )
                    <a href='{{url("/view_invoice/$orderid")}}' target="_blank">view invoice</a>
                  @endif
              </td>
              <td>@if($vd->voucher) {{ $vd->voucher->date }} @endif</td>
              <td>{{ $vd->narration }}</td>
              <td>{{ $vd->voucher_id }}</td>
              @if($c->vat == 0)
              <td>{{ $vd->dr + $vat}}  </td>
              @else
              <td>{{ $vd->dr}}  </td>
              @endif
              <td>{{ $vd->cr }}</td>
              <td>{{ number_format($balance,2) }}</td>
            </tr>
          @endforeach
          <tr>
            <td colspan="6" style="text-align: right !important;">Total</td>
            @if($c->vat == 0)
            <td>{{ $c->total_sale()->sale + $vat_sum }}</td>
            @else
            td>{{ $c->total_sale()->sale }}</td>
            @endif
            <td>{{ $c->total_payment()->payment }}</td>
            <td>{{ number_format($balance,2) }}</td>
          </tr>
          <tr>
            <td colspan="8" style="text-align: right !important;"><strong>Total Receivable (exl Guarantee Payments):</strong></td>
            <td>{{ number_format($balance,2) }}</td>
          </tr>
      </table>
    </div>

    <div class="col-md-12 customer_credit_limit accounts" id="Bookmark">

    @if(Entrust::hasRole('owner'))      
    <div class="x_panel">
      <div class="x_title">
          <h2>Customer Credit Limit</h2>
          <div class="clearfix"></div>
      </div>
      <div class="x_content">
      <form class="form" method="post" action="{{ url('/update_credit_limit') }} ">
        {!! csrf_field() !!}
        <div class="col-md-6">
          <label>Current Limit £:</label>
          <input  type="text" class="form-control" name="credit_limit" value="{{$c->credit_limit}}" >
          <input  type="hidden" name="customer_id" value="{{$c->customer_id}}" >
          
          <!-- id="single_cal4"  aria-describedby="inputSuccess2Status4" -->
        </div>
        <div class="col-md-6">
          <label>Current Limit %:</label>
          <input  type="text" class="form-control" name="credit_limit_percent" value="{{$c->credit_limit_percent}}">
        </div>
        <div class="col-md-6">Request Customer detail for credit limit , if status is restricted: <input type="checkbox" name="req_detail" id="req_detail"></div>
        <div class="col-md-6"><input type="submit" value="Update Credit Limit" class="btn btn-success"></div>
      </form>
      </div>
    </div>
    @endif
    </div> <!-- customer_credit_limit -->
    @include('accounts.pending')
    @include('accounts.payments')
    </div><!-- col-md-9 -->
    <script type="text/javascript">
      $( document ).ready(function(){
        window.location.hash = "Bookmark";
      })
    </script>
@endsection