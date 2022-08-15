@extends('layouts.app')

@section('content')
<div class="">

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                         
                <div class="page-title">
                <div class="title_left">&nbsp;</div>
                  <div class="title_right">
                    <a href="javascript:void()" class="btn btn-warning right" style="float: right;">{{ $customer->business_name}}</a>
                    <a href="javascript:void()" class="btn btn-danger right"  style="float: right;">{{ \Session('warehouse') }}</a>
                    <a href="{{url('/viewbucket')}}" class="btn btn-success" style="float: right;">View Bucket</a> 
                  </div>                  
                </div>
                <div class="x_panel">
                  <div class="x_title">
                  @if($item->main_category) {{$item->main_category->cat_name}} -> @endif
                  @if($item->sec_category) {{ $item->sec_category->cat_name }} -> @endif
                  {{ $item->third_category->cat_name }}
                  - {{ $item->style }} - {{ $item->title }} - - {{ $item->design }} 
                  </div>

                  <div class="x_content">  
                     <form method="post" action="{{ url('/addtobucket') }}">
                      {!! csrf_field() !!}        
                    <div class="col-md-6">
                      <table class="table table-striped table-bordered dt-responsive nowrap">
                        <tr>
                        <th>Item Code</th>
                        <th>Design Code</th>
                        <th>Size</th>
                        <th>Color</th>
                        <th>Available Qty</th>
                        <th>Required Qty</th>
                        </tr>
                        @php 
                        $colors_arr = array('#2F4F4F','#696969','#808080','#778899','#A9A9A9','#A9A9A9','#C0C0C0','#d9d9d9','#e4e4e4','#D3D3D3','#f9f9f9','#f0f0f0','#DCDCDC','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff','#ffffff');
                        $color = ''; $bgcolor = ''; $count = 0; 
                        @endphp
                        @foreach($item->sizeAndColors as $sc)
                          @if($sc->color != $color)
                            @php 
                              $color = $sc->color;
                              $bgcolor = $colors_arr[$count];
                              if($sc->color_count <= 0 ) $bgcolor = '#ffffff';
                              $count++;
                            @endphp
                          @endif
                          <tr style="background-color: {{ $bgcolor }}">
                            <td>{{ $sc->item_sc_code  }}</td>
                            <td>{{ $sc->design_code  }}</td>
                            <td>{{ $sc->size  }}</td>
                            <td>{{ $sc->color  }}</td>
                            <td>{{ $sc->aqty  }}</td>
                            <td style="text-align: center;"><input class="form-control qtyf" type="number" name="rqty[{{ $sc->item_sc_code  }}]" max="{{ $sc->aqty  }}" value="" style="width: 100px; margin: 0 auto;" min="1"></td>
                          </tr>
                        @endforeach
                      </table>
                    </div>

                    <div class="col-md-6">
                      <div class="x_panel">
                          <div class="col-md-12">
                        @if(Entrust::hasRole('dropshipper'))
                            Charged Price :<input type="text" name="c_price" id="c_price" class="form-control" style="width: 100px; display: inline; margin-left: 20px; margin-bottom: 20px" readonly="" required="required" value="{{$price['cp']}}"> <br />
                        @else
                            Cost Price : {{$price['price']}} 
                            <br />
                            Charged Price :<input type="number" step=".01" name="c_price" id="c_price" class="form-control" style="width: 100px; display: inline; margin-left: 20px; margin-bottom: 20px" required="required" value="{{$price['price']}}" min="{{$price['min']}}"> <br />

                        @endif
                            <input type="hidden" name="design_code" id="design_code" value="{{ $item->design_code }}">
                            <input type="hidden" name="cost_price" id="cost_price" value="{{$price['price']}}" />
                          </div>
                          <div class="col-md-12">
                            <input type="submit" onclick="return validate();" value="Add To Bucket" name="place_order" class="btn btn-success">
                            <a href="{{ url('/listing') }}" class="btn btn-info">View More Items</a>
                            <a target="_blank" href='{{ url("/item_sc_detail/$item->design_code") }}' class="btn btn-info">Add a Size/Color</a>
                          </div> 
                          <div class="col-md-12">
                            @foreach($item->images  as $img)
                                @php $img = $img->image @endphp
                                <img src=' {{ url("public/images/thumb/$img")}} '  data-large='{{ url("public/images/large/$img")}}' class="myImg" onclick="showimage(this)"/>
                            @endforeach   
                          </div>
                      </div>
                    </div>
                    </form>
                  </div>
                </div>
              </div>

            </div>         
</div>
<script type="text/javascript">
  function validate(){
    if($('#c_price').val() == 0){
      alert('Charged Price Cannot be Zero');
      return false;
    }
    /*if($('#c_price').val() < $('#cost_price').val()){
      alert('Charged Price Cannot be Less Than The Cost Price');
      return false;
    }*/
    var c = 0;
    $('.qtyf').each(function(i, obj) {
      if( $(obj).val() != '') c = 1;
    });
    if(c == 0){
      alert('Required Quantity Fields Cannot be emty');
      return false;
    }else{
      return true;
    }
  }
</script>
<style type="text/css">
  td{color: #000000 !important; }
</style>
  @include('imagepopup')
@endsection