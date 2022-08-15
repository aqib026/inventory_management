@extends('layouts.blank')

@section('content')

    <div class="col-md-12">
     <form method="post" action="{{ url('/add_shipping') }}">
      {!! csrf_field() !!}  
      <table class="table">
        <tr>
          <td>Shipping Charges</td>
          <td><input type="text" name="sc" required="" value="{{$o->shipment_charges}}" /></td>
          <td>Tracking #</td>
          <td>
            <input type="text" name="tracking" value="{{$o->tracking_num}}" />
            <input type="hidden" name="order_no" value="{{$o->order_no}}">
          </td>
          <td><input type="submit" value="Update" class="btn btn-success  btn-sm"></td>
        </tr>
      </table>
      </form>

    </div>

@endsection