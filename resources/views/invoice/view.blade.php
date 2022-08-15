@extends('layouts.blank')

@section('content')
    @include('invoice/company')
    @include('invoice/info')
    

    <span id="box-info" class="col-xs-12"></span>
    <div class="col-md-12" ><hr /></div>
	<script type="text/javascript" src="{{ asset('public/js/cw_utils.js') }}?var=6"></script>
    
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
        @if(isset($invoice))
          @if($order->customer->vat == 0  &&  $invoice->vat != 0)
          <th>VAT 20%</th>
          <th>Total</th>
          @endif
        @endif
        </tr>
        @php $sub_total = 0; $vat_total = 0; $rows_total=0; @endphp
        @if( count($order->countByDesign()) > 0)
          @foreach($order->countByDesign() as $line)
           @php 
           $sub_total += ($line->fqty * $line->charged_price);
           if($line->design_detail->category != 'Kids'){
             $vat        = $line->fqty * $line->charged_price * 0.2;
             $vat_total = $vat + $vat_total;
           }else{
            $vat = 0;
         }
            
          if($order->customer->vat == 1)
          {
           $row_total  = ($line->fqty * $line->charged_price) + $vat ;
           $rows_total += $row_total;   }

           if(isset($invoice)){
           if($order->customer->vat == 0 && $invoice->vat != 0 ) {
           $row_total  = ($line->fqty * $line->charged_price);
           $rows_total += $row_total;   }    
          }
                  
           @endphp
            <tr>
              <td>{{$line->design_code}}</td>
              <td>&nbsp;&nbsp;&nbsp;{{$line->design_detail->style}}</td>
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
          @endforeach

        @endif
        <tr>
          <td colspan="4" style="text-align: right !important;">Sub Total</td>
          <td>{{$sub_total}}</td>
          @if($order->customer->vat == 1 )
          <td>{{$vat_total}}</td>
          <td>{{$rows_total}}</td>
          @endif
        @if(isset($invoice))
          @if($order->customer->vat == 0 && $invoice->vat != 0)
          <td>{{$invoice->vat}}</td>
          <td>{{$rows_total+ $invoice->vat}}</td>
          @endif
        @endif
        </tr>
        <tr>
          <td colspan="4" style="text-align: right !important;">Discount 0%</td>
          <td>0%</td>
        </tr>
        <tr>
          <td colspan="3" style="text-align: right !important;">
          @if($invoice == '')  
          <a class="modal_link" href='{{ url("/shipping_charges/$order->order_no") }}'>click here to add shipping charges</a>
          @endif  
          </td>
          <td style="text-align: right !important;">Shipment Charges</td>
          <td>{{$order->shipment_charges}}</td>
        </tr>
        <tr>
          <td colspan="4" style="text-align: right !important;">GRAND TOTAL</td>
          <td>
          @if($order->customer->vat == 1 )
            {{$rows_total + $order->shipment_charges}}
             @else
            {{$sub_total + $order->shipment_charges}}
          @endif

        @if(isset($invoice))
          @if($order->customer->vat == 0 && $invoice->vat != 0)
            {{$rows_total + $order->shipment_charges + $invoice->vat}}
          @endif
        @endif
          </td>
        </tr>

      </table>
	  <div id="orders-boxes" style="display: none">{{$order->filledBoxNumbers()}}</div>
      <script type="text/javascript">
      	showBoxNums();
      </script>
      
      <div class="col-md-12" style="text-align: right;">
          @if($invoice == '' && ( $order->order_status == 'filled' || $order->order_status == 'dispatched'))
            <form action='{{ url("/generate_invoice") }}' method="post">
              {!! csrf_field() !!}
              <input type="hidden" name="order_no" value="{{$order->order_no}}" />
              <input type="hidden" name="customer_id" value="{{$order->customer_id}}" />
              <input type="hidden" name="amount" value="{{$sub_total}}" />
              <input type="hidden" name="sc" value="{{$order->shipment_charges}}">
              <input type="hidden" name="vat" value="{{$vat_total}}" />
              <input type="submit" value="Generate Invoice" class="btn btn-success btn-sm">
            </form>
          @endif
      </div>
      <div class="col-md-12">
        <div class="payment_terms">
          <p><strong>Payment Terms :</strong></p>
          <ol>
            <li>We offer the facility of 30 days credit from the issuing date of invoice.</li>
            <li> The credit facility of 30 days will be sanctioned on approval with 16 sixty, considering the bank references of the buyer. If not available, the payment has to be settled at the time of delivery or in advance on confirmation of order.</li>
            <li>In case of delay in payment during the credit period, your account will be closed on the 10th day on completion of credit period (30 days), thereafter no goods will be supplied unless the payment is settled. In order to re-activate the account, the buyer has to pay a cost towards administration fee GBP 25 (British Pounds Twenty five only).</li>
            <li>
              All goods shall remain the property of 16 sixty until full payment has been paid. 16 sixty reserves the right to claim the goods without any restrictions, provided the full payment is not settled. GFL has the right to claim the goods at any given point of time, unless there is a written statement of credit limit.
            </li>
          </ol>
          <p><strong>Return Terms :</strong></p>
          <ol>
            <li>All faults or shortages must be notified within 48 hours and any returns should be made within 7 working days.</li>
            <li>All non faulty returns are subject to a 25% handling fee.</li>
          </ol>
          <p><strong>Note.</strong> In case of legal proceedings, all the expenses towards legal proceedings will be borne by the buyer </p>
        </div>
      </div>
    </div>


@endsection