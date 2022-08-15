@extends('layouts.app')

@section('content')
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3><a href="{{ url('/home')}}">Items</a> <small></small></h3>
    </div>
  </div>
  <div class="clearfix"></div>

  <div class="row">

    <div class="col-md-12 col-xs-12">

      
      <div class="x_panel">
        <div class="x_title">
          <h2 style="width: 100%;"><small>design code : </small> 
          
          </h2>

          <div class="clearfix"></div>
        </div>
        <div class="x_content">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-4 col-sm-12 col-xs-12" for="first-name">Design Code<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">                   
                    <label class="control-label col-md-4 col-sm-12 col-xs-12">{{ $item->design_code }}</label>
                  </div>
                </div>
                <form method="post" action="{{ url('/save_sc') }}" class="form-horizontal form-label-left">
                  {!! csrf_field() !!}
                <div class="form-group">
                  <label class="control-label col-md-4 col-sm-12 col-xs-12" for="first-name">New Color<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">       
                    <input type="text" value="" id="new_color" name="new_color" class="form-control" />            
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-4 col-sm-12 col-xs-12" for="first-name">New Size<span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-12 col-xs-12">       
                    <input type="text" value="" name="new_size" class="form-control" />
                    <input type="hidden" name="design_code" value="{{ $item->design_code }}" />            
                  </div>
                </div>

                <div class="form-group" style="text-align: center;"> <input class="btn btn-success" type="submit"></div>
                </form>                                              

                  <table class="table table-striped table-bordered dt-responsive nowrap">
                    <tr>
                      <td>Item No</td>
                      <td>Design Code</td>
                      <td>Item Code</td>
                      <td>Size</td>
                      <td>Color</td>
                      <td>Available Qty</td>
                    </tr>

                    @forelse($item->sizeAndColors as $isc) 
                    <tr>
                      <td>{{$isc->item_sc_code}}</td>
                      <td>{{$isc->design_code}}</td>
                      <td>{{$isc->item_sku_code}}</td>
                      <td>{{$isc->size}}</td>
                      <td>{{$isc->color}}</td>
                      <td>{{$isc->aqty}}</td>
                    </tr>
                    @empty
                      <tr> <td colspan="6">No Record Found !</td> </tr>
                    @endforelse                    
                  </table>

                </div>

                <div class="col-md-6">
                  @forelse($item->images as $img) 
                    @php $img = $img->image @endphp
                    <img src=' {{ url("public/images/thumb/$img")}} ' />
                  @empty
                    <p> No Image Found !</p>
                  @endforelse                          
                </div>
              <!-- 1st tab closer coainter -->
            </div>
    
            </div>         
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function() {


    $( "#new_color" ).autocomplete({
      source: "{{ url('/colors_list')}}",
      minLength: 2,
      select: function( event, ui ) {
      }
    });


});
</script>
@endsection
