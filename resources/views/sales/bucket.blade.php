@extends('layouts.app')

@section('content')
<div class="">

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">

      {!! csrf_field() !!}
      <div class="x_panel">
        <div class="x_title">
          Bucket Details
        </div>

        <div class="x_content">  
         <form method="post" action="{{ url('/complete_order') }}">
          {!! csrf_field() !!}        
          <div class="col-md-6">
            <table class="table table-striped table-bordered dt-responsive nowrap">
              <tr>
                <th>&nbsp;</th>
                <th>Item Code</th>
                <th>Design Code</th>
                <th>Size</th>
                <th>Color</th>
                <th>Required Qty</th>
              </tr>

              @foreach($bucket->line as $sc)
              <tr>
                <td><a href='{{url("/remove_line/$sc->entry_id")}}' onclick="return confirm('Are you sure you want to remove this item?')">&nbsp;&nbsp;&nbsp;<i class="fa fa-close"></i>&nbsp;&nbsp;&nbsp;</a></td>
                <td>{{ $sc->item_no  }}</td>
                <td>{{ $sc->design_code  }}</td>
                <td>{{ $sc->size  }}</td>
                <td>{{ $sc->color  }}</td>
                <td>{{ $sc->require_qty }}</td>                            
              </tr>
              @endforeach
            </table>
          </div>

          <div class="col-md-6">

            <div class="x_panel">
              <div class="col-md-12">
                <label  class="col-md-12">Select Address 
                 <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bs-example-modal-lg">Add Address</button> 
               </label>
               <input type="radio" name="cust_add" checked="checked" value="0"> {{ $customer->customer_add }} <br />
               @foreach($customer->address_list as $cd)
               <input type="radio" name="cust_add" value="{{ $cd->address_id }}"><b>Name:</b>{{ $cd->fname }} {{ $cd->lname }} , <b>Address</b> {{ $cd->address }} <br />
               @endforeach
             </div>
          </div>
          @if(!Entrust::hasRole('dropshipper'))
          <div class="x_panel">
              <label  class="col-md-12">Select Payment Term.</label>
              <select required="" name="payment_terms" id="payment_terms" class="form-control">
                <option value="">Select Payment Terms</option>
                @foreach($terms as $k => $t)
                  <option value="{{$t}}">{{$t}}</option>
                @endforeach
              </select>
          </div>
          @else
          <select style="visibility: hidden;" name="payment_terms" id="payment_terms">
            <option value="terms are agree for  : Customer will  pay all this invoice  balane on next invoice">1</option>
          </select>
          @endif

          <div class="x_panel">
              <div class="col-md-6">
              <label  class="col-md-12">In How Many Days Payment Will Be Made.</label>
              <input type="text" value="5" name="expec_pay_date" id="expec_pay_date" class="form-control" required="" />
              </div>
              <div class="col-md-6">
              <label  class="col-md-12">Add PO Number</label>
              <input type="text" value="" name="po_num" id="po_num" class="form-control" />
              </div>
          </div>

          <div class="x_panel">
              <div class="col-md-12">
              <label  class="col-md-12">Add any other note ( Except the item prices ) related to this order.</label>
              <input type="text" name="note" id="note" class="form-control" />
              </div>
          </div>

          <div class="x_panel">
             <div class="col-md-12">
             @if($customer->r_date != '0000-00-00' && $customer->r_date <= date('Y-m-d'))
             <div class="alert alert-danger">Order Can not be completed! the customer is restricted since {{ $customer->r_date }}</div>
             @else
             @if(count($bucket->line) > 0)
              <input type="submit" onclick="return validate();" value="Complete Order" name="complete_order" class="btn btn-success">
              @endif
              <a href="{{ url('/listing') }}" class="btn btn-info">Add More Item In Buckets</a>
              @endif
            </div> 
          </div>

        </div>
      </form>
    </div>
  </div>
</div>

</div>         
</div>



<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Add New Address</h4>
      </div>
      {!! Form::model('', ['url' => ['/add_address']]) !!}
      <div class="modal-body">
        <div class="row">
          
          <div class="col-md-6">
            {!! Form::label('fname', 'First Name')  !!}
            {!! Form::text('fname', '', ['class' => 'form-control','required'=>''])  !!}

            {!! Form::label('lname', 'Last Name')  !!}
            {!! Form::text('lname', '', ['class' => 'form-control','required'=>''])  !!}

            {!! Form::label('address', 'Address')  !!}
            {!! Form::textarea('address', '', ['class' => 'form-control','required'=>''])  !!}

            {!! Form::label('city', 'City')  !!}
            {!! Form::text('city', '', ['class' => 'form-control','required'=>''])  !!}

          </div>
          <div class="col-md-6">

            {!! Form::label('country', 'country')  !!}
            {!! Form::select('country',['UK'=>'United Kingdon','Pak'=>'Pakistan'],'', ['class' => 'form-control','required'=>''])  !!}

            {!! Form::label('postcode', 'Post Code')  !!}
            {!! Form::text('postcode', '', ['class' => 'form-control','required'=>''])  !!}

            {!! Form::label('mobile_no', 'Mobile No')  !!}
            {!! Form::text('mobile_no', '', ['class' => 'form-control','required'=>''])  !!}

            {!! Form::label('office_no', 'Office No')  !!}
            {!! Form::text('office_no', '', ['class' => 'form-control','required'=>''])  !!}

            <input type="hidden" name="customer_id" value="{{ \Session('co_cust_id') }}">

          </div>
        </div>
        

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add Address</button>
      </div>
      {!! Form::close() !!}

    </div>
  </div>
</div>
<script type="text/javascript">
  function validate(){
    return true;
  }
</script>

@endsection