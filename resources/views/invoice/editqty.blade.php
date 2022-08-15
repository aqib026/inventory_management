@extends('layouts.blank')

@section('content')
    @include('invoice/company')
    
    @include('invoice/info')

    <div class="col-md-12"><hr /></div>

    <div class="col-md-12">
      <table class="table">
        <tr>
          <th>Item No</th>
          <th>Design Code</th>
          <th>Size</th>
          <th>Color</th>
          <th>Req Qty</th>
          <th>Filled Qty</th>
          @if( Auth::user()->can('unit_price') )
          <th>Unit Price</th>
          @endif
        </tr>
        @if( count($order->line) > 0)
          @foreach($order->line as $line)
            <tr>
              <td>{{$line->item_no}}</td>
              <td>{{$line->design_code}}</td>
              <td>{{$line->size}}</td>
              <td>{{$line->color}}</td>
              <td><a href='{{ url("/edit_qty/$order->order_no/$line->item_no") }}' class='ls-modal'>{{$line->require_qty}}</a></td>
              <td>{{$line->filled_qty}}</td>
              @if( Auth::user()->can('unit_price') )
              <td>{{$line->charged_price}}</td>
              @endif
            </tr>
          @endforeach
        @endif

      </table>
      <p><b>Note:</b>{{$order->note}}</p>

    </div>

<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Order # {{$order->order_no}}</h4>
      </div>
      <div class="modal-body">
        

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>


    </div>
  </div>
</div>

<script type="text/javascript">
  $('.ls-modal').on('click', function(e){
  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});
</script>
@endsection