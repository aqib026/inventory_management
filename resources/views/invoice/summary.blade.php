@extends('layouts.blank')

@section('content')

    @include('invoice/company')
   
    @include('invoice/info')

    <div class="col-md-12"><hr /></div>

    <div class="col-md-12">
      <table class="table">
        <tr>
          <th>Style No</th>
          <th>Description</th>
          <th>Qty</th>
          @if( Auth::user()->can('unit_price') )          
          <th>Unit Price</th>
          @endif
          <th>Sub Total</th>
          @if($order->customer->vat == 1)
          <th>VAT 20%</th>
          <th>Total</th>
          @endif
        </tr>
        @php $sub_total = 0; $vat_total = 0; $rows_total=0; @endphp
        @if( count($order->countByDesign()) > 0)
          @foreach($order->countByDesign() as $line)
           @php 
           if($line->fqty == 0)
           {
              $sub_total += ($line->total * $line->charged_price);
              $vat        = $line->total * $line->charged_price * 0.2;
              $vat_total += $line->total * $line->charged_price * 0.2;
              $row_total  = ($line->total * $line->charged_price) + $vat;
              $rows_total += $row_total;
           }
           else
           {
              $sub_total += ($line->fqty * $line->charged_price);
              $vat        = $line->fqty * $line->charged_price * 0.2;
              $vat_total += $line->fqty * $line->charged_price * 0.2;
              $row_total  = ($line->fqty * $line->charged_price) + $vat;
              $rows_total += $row_total;    
           }       
           @endphp
           @if($line->fqty == 0)
            <tr>
              <td>{{$line->design_code}}</td>
              <td><b>{{$line->design_detail->category}}</b>&nbsp;&nbsp;&nbsp;{{$line->design_detail->style}}</td>
              <td>{{$line->total}}</td>
              @if( Auth::user()->can('unit_price') )
              <td>{{$line->charged_price}}</td>
              @endif
              <td>{{$line->total * $line->charged_price}}</td>
              @if($order->customer->vat == 1)
              <td>{{$vat}}</td>
              <td>{{$row_total}}</td>
              @endif
            </tr>
          @else
            <tr>
              <td>{{$line->design_code}}</td>
              <td><b>{{$line->design_detail->category}}</b>&nbsp;&nbsp;&nbsp;{{$line->design_detail->style}}</td>
              <td>{{$line->fqty}}</td>
              @if( Auth::user()->can('unit_price') )
              <td>{{$line->charged_price}}</td>
              @endif
              <td>{{$line->fqty * $line->charged_price}}</td>
              @if($order->customer->vat == 1)
              <td>{{$vat}}</td>
              <td>{{$row_total}}</td>
              @endif
            </tr>
          @endif
          @endforeach
        @endif
        <tr>
          <td colspan="4" style="text-align: right !important;">Sub Total</td>
          <td>{{$sub_total}}</td>
          @if($order->customer->vat == 1)
          <td>{{$vat_total}}</td>
          <td>{{$rows_total}}</td>
          @endif
        </tr>
        <tr>
          <td colspan="4" style="text-align: right !important;">Discount 0%</td>
          <td>0%</td>
        </tr>
        <tr>
          <td colspan="4" style="text-align: right !important;">Shipment Charges</td>
          <td>{{$order->shipment_charges}}</td>
        </tr>
        <tr>
          <td colspan="4" style="text-align: right !important;">GRAND TOTAL</td>
          <td>
          @if($order->customer->vat == 1)
          {{$rows_total + $order->shipment_charges}}
          @else
          {{$sub_total + $order->shipment_charges}}
          @endif
          </td>
        </tr>
      </table>


    </div>
<style>
  body{
    background-color: #317676 !important;
  }
</style>

@endsection