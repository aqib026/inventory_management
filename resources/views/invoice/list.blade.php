@extends('layouts.blank')

@section('content')
	<span class="sm">
    @include('invoice/company')
    @include('invoice/info')    
	</span>
    <script type="text/javascript" src="{{ asset('public/js/cw_utils.js') }}?var=6"></script>
    
    <style>
	    .cssHide,.printHide {display:none;}
        #order-list .num{width: 8%;}
        #order-list .num.fill input{width: 60%;}
        #order-boxes {width: 3.5in;height: 5.6in;}  
        .btn-success {padding: 0px 18px;}
        .FR {float: right} 
        .fontMain {font-size: 56pt;}
        .fontSlim {font-weight: lighter;font-size: 46pt;}
        .lineL {border-left-style: inset;}
        .lineR {border-right-style: inset;}
        .lineUp {border-top-style: inset;}
        .lineDn {border-bottom-style: inset;}
        
         @media print
         {
            #order-boxes{margin-left: 27%;};
         }
    </style>
     <form method="post">
                  {!! csrf_field() !!}
    <img class="cssHide" id="sixty16" src='{{ url("/")}}/resources/views/invoice/address.jpg'></img>
	<div class="col-xs-3">
		<span id="packing_btn" class="btn btn-success FR" onclick="startBoxes({{$order->order_no}}, this, event)">
			Paking
			<span class="btn-warning old">[ old ]</span>
		</span>
	</div>
                  </form>
    
	<div class="col-md-12" data-url='{{ url("/")}}'>
      <table class="table" id="order-list">
        <tr>
          <th class="col-xs-2">Index</th>
          <th class="sm">Item No</th>
          <th class="col-xs-2">Design Code</th>
          <th class="col-xs-2">Size</th>
          <th class="col-xs-2">Color</th>
          <th class="sm" class="cal">Available in Store</th>
          <th class="cal col-xs-2">Req Qty</th>
    @include('invoice/info')
    
    <script type="text/javascript" src="{{ asset('public/js/cw_utils.js') }}"></script>
    
    <style>
	    .cssHide {display:none;}
        #order-list .num{width: 8%;}
        #order-list .num.fill input{width: 60%;}
    </style>
    
	<div class="col-xs-1">
		<a href="javascript:void(0)" class="btn btn-success" style="padding: 3px 22px; " 
			onclick="startBoxes({{$order->order_no}}, this)">Start</a>
	</div>
    <div class="col-md-12"><hr /></div>
	
	<div class="col-md-12">
      <table class="table" id="order-list">
        <tr>
          <th>Item No</th>
          <th>Design Code</th>
          <th>Size</th>
          <th>Color</th>
          <th class="cal">Available in Store</th>
          <th class="cal">Req Qty</th>
          <th class="cal">Filled Qty</th>
        </tr>
        @php ( $total = 0)
        @php ( $rowIndex = 0)
        @if( count($order->line) > 0)
          @foreach($order->line as $line)
          @php
          	$avilable = \App\ItemSizeColor::getqty1($line->item_no);
			$rowIndex++;
          @endphp
          @php ( $total += $line->filled_qty)
            <tr data-row-index="{{$rowIndex}}" >
            	<td class="col-xs-2">{{$rowIndex}}</td>
              <td class="sm">{{$line->item_no}}</td>
              <td class="col-xs-2">{{$line->design_code}}</td>
              <td class="col-xs-2">{{$line->size}}</td>
              <td class="col-xs-2">{{$line->color}}</td>
              <td class="cal sm">{{$avilable[0]}}</td>
              <td class="cal col-xs-2">{{$line->require_qty}}</td>
              <td class="cal fill">
              	<span>{{$line->filled_qty}}</span>
              	<input value="{{$line->filled_qty}}" 
              		   data-id="{{$line->entry_id}}"
              		   data-p="{{$line->charged_price}}" data-size="{{$line->size}}"
              		   data-code="{{$line->design_code}}"
              		   data-min="{{$avilable[0]}}" data-max="{{$line->require_qty}}"
              		   data-box-num = "{{$line->carton_num}}"
              		   class="cssHide" onchange="generateSummary(this);"
              		   type="number" min="0" max="{{$line->require_qty}}"
              		   inputmode="numeric" pattern="[0-9]*"></input>
          @endphp
          @php ( $total += $line->filled_qty )
            <tr>
              <td>{{$line->item_no}}</td>
              <td>{{$line->design_code}}</td>
              <td>{{$line->size}}</td>
              <td>{{$line->color}}</td>
              <td class="cal">{{$avilable[0]}}</td>
              <td class="cal">{{$line->require_qty}}</td>
              <td class="cal fill">
              	<span>{{$line->filled_qty}}</span>
              	<input value="{{$line->filled_qty}}" 
              		   data-p="{{$line->charged_price}}" data-size="{{$line->size}}"
              		   data-code="{{$line->design_code}}"
              		   data-min="{{$avilable[0]}}" data-max="{{$line->require_qty}}"
              		   type="text" class="cssHide" onkeyup="generateSummary(this);"></input>
              </td>
            </tr>
          @endforeach
        @endif
        <tr>
          <td colspan="5" style="text-align: right !important;">Total Given Qty</td>
          <td id="total" >{{$total}}</td>
        </tr>
      </table>
      <script type="text/javascript">
      		isAlreadyFilled('{{$order->order_no}}', '{{$order->order_status}}', '{{$order->delivered_date}}');
      </script>
      <div class="col-md-12">
        <table class="table">
        <tr>

         @foreach($order->countByDesign() as $dc)           
           <td class="imgblocks">
            @if($dc->cover_image)
            @php $img = $dc->cover_image->image @endphp
            <img src=' {{ url("public/images/thumb/$img")}} ' />
            @endif
            <br /><br /> @if($dc->design_code) {{$dc->design_code}} @endif
            <br /><br /> @if($dc->design_detail) {{$dc->design_detail->wl}} @endif
           </td>
         @endforeach
        </tr>
        </table>
      </div>
      <p><b>Note:</b>{{$order->note}}</p>
    </div>
<style type="text/css">
  .imgblocks{
    padding: 2px;
    border: 1px solid #cecece;
    margin: 2px;
  }
</style>
@endsection