@extends('layouts.app')

@section('content')
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>New Purchase order NO <bold>@if(isset($pending_order)){{$pending_order->p_order_no}}@endif</bold></h3>
    </div>
  </div>
  <div class="clearfix"></div>

  <div class="row">

    <div class="col-md-4 col-xs-12">
    
      {!! csrf_field() !!}
      <div class="x_panel">
        <div class="x_title">
              <h2>Select Supplier To Make Purchase</h2>
              <div class="row">
                <div class="col-md-12">
                <form id="demo-form2" action="{{ url('/purchase') }}" method="get" data-parsley-validate class="form-horizontal form-label-left">
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Select Supplier<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="supplier_id" id="supplier_id" required="required"   class="form-control col-md-7 col-xs-12">
                      <option value="">Select Supplier</option>
                      @foreach($suppliers as $supplier)
                        <option @if($supplier_id == $supplier->supplier_id ) selected="selected" @endif; value="{{$supplier->supplier_id}}">{{$supplier->supplier_name}}</option>
                      @endforeach
                    </select>
                    @if($supplier_id == '')
                    <input type="submit" value="Make Purchase Order" class="btn btn-info" style="margin-top: 10px;">
                    @endif
                  </div>
                </div>    
                </form>
                </div>    
                </div>
          <div class="clearfix"></div>
        </div>
         @if($supplier_id != '')
        <div class="x_content">
        <form id="demo-form2" action="{{ url('/purchase') }}" method="get" data-parsley-validate class="form-horizontal form-label-left">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif          

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Select Design<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="design_code" id="design_code" required="required"   class="form-control col-md-7 col-xs-12">
                      <option value="">Select Design Code</option>
                      @foreach($designs as $design)
                        <option value="{{$design->design_code}}">{{$design->design_code}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Select Color<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="color" id="color" required="required"   class="form-control col-md-7 col-xs-12">
                      <option value="">Select Color</option>
                      @foreach($colors as $color)
                        <option value="{{$color->color}}">{{$color->color}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Select Size<span class="required">*</span>
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="size" id="size" required="required"   class="form-control col-md-7 col-xs-12">
                      <option value="">Select Size</option>
                        {!! \App\Purchaseorder::Sizes(); !!}
                    </select>
                  </div>
                </div>

                <div class="row" id="prow_lists">
                  
                </div>
                   <div class="loader"></div>
                 <div class="form-group btns" >
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="hidden" name="p_order_no" id="p_order_no" value="{{ $pending_order->p_order_no }}">
                    <input type="button" id="add_item" value="Add Item"  class="btn btn-info pull-right">
                    <input type="button" value="Add Rows" id="add_row" class="btn btn-info pull-right">
                  </div>
                </div>               

                </form>
      </div>
      @endif

    </div>
              </div>  <!-- CLOSING OF COL_MD_6 -->

    <div class="col-md-8 col-xs-12" id="items_lists">
      
    </div>          
            </div>         
</div>
@endsection

@section('scripts')
  <script type="text/javascript">
    $( document ).ready(function(){

      $('#add_row').click(function(){

      if( $('#size').val() == '' ){ alert('Size is required'); return; }
      if( $('#color').val() == '' ){ alert('Color is required'); return; }
      if( $('#design_code').val() == '' ){ alert('Design Code is required'); return; }
        $.ajax({
          type:'GET',
          url : "{{ url('/add_prows') }}",
          data: {size:$('#size').val()},
          beforeSend:function(){
            $('.loader').show();
            $('.btns').hide();            
          },
          success:function(response){
            $('.loader').hide();
            $('.btns').show();            
            $('#prow_lists').html(response);
          }
        });
      });

      $('#add_item').click(function(){

        if( $('#size').val() == '' ){ alert('Size is required'); return; }
        if( $('#color').val() == '' ){ alert('Color is required'); return; }
        if( $('#design_code').val() == '' ){ alert('Design Code is required'); return; }
        if( $('#weight').val() == '' ){ alert('Weight Field is required'); return; }
        var qty = 0;
        var qty_arr = {};
        $(".qty").each(function() {
          if($(this).val() > 0) qty = 1;
          //if($(this).val() > 40) { qty = 41; }
          qty_arr[$(this).attr('id')] = $(this).val();
        });
        if(qty == 0 ){ alert('Please enter the proper quantity'); return; }
        //@if(Entrust::hasRole('buyer'))
        //  if(qty == 41 ){  alert('Max Qty Can Only Be 40'); return; }
        //@endif

        var json = JSON.stringify( qty_arr );
        $.ajax({
          type:'GET',
          url : "{{ url('/add_purchase_item') }}",
          data: {p_order_no:$('#p_order_no').val(),design_code:$('#design_code').val(),color:$('#color').val(),size:json,weight:$('#weight').val()},
          beforeSend:function(){
            $('.loader').show();
            $('.btns').hide();            
          },          
          success:function(response){
            $('.loader').hide();
            $('.btns').show();            
            $('#items_lists').html(response);
            $('.qty').val(''); 
            $('#size').val('');
          }
        });
      });

      $('#items_lists').on('click','.glyphicon-remove',function(){

          n = confirm('Are you sure you want to delete this item');
          $.ajax({
            type:'GET',
            url : "{{ url('/remove_purchase_item') }}",
            data: {entry_id:$(this).data('itemid'),p_order_no:$('#p_order_no').val()},
            success:function(response){
              $('#items_lists').html(response);
            }
          });
      }); 

        $.ajax({
          type:'GET',
          url : "{{ url('/add_purchase_item') }}",
          data: {p_order_no:$('#p_order_no').val()},
          success:function(response){
            $('#items_lists').html(response);
          }
        });

    });
  </script>
@stop