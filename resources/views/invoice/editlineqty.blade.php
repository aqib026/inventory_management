@extends('layouts.blank')

@section('content')

    <div class="col-md-12">
     <form method="post" action="{{ url('/update_edit_qty') }}">
      {!! csrf_field() !!}  
      <table class="table">
        <tr>
          <td>Item No</td>
          <td>Design Code</td>
          <td>Size</td>
          <td>Color</td>
          <td>Available Qty</td>
          <td>Req Qty</td>
          <td>#</td>
        </tr>
            <tr>
              <td>{{$line->item_sc_code}}</td>
              <td>{{$line->design_code}}</td>
              <td>{{$line->size}}</td>
              <td>{{$line->color}}</td>
              <td>{{$line->aqty}}</td>
              <td>
              <input type="number" class="form-control" min="0" required="required" name="require_qty" value="">
              <input type="hidden" name="order_no" value="{{$order_no}}" >
              <input type="hidden" name="item_no" value="{{$line->item_sc_code}}">
              </td>
              <td><input type="submit" name="update" value="Update" class="btn btn-primary btn-sm"></td>
            </tr>

      </table>
      </form>

    </div>

@endsection