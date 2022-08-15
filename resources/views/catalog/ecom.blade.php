@extends('layouts.blank')

@section('content')
        <!-- page content -->
        <div class="container">
        <div class="right_col" role="main">

          <div class="">            

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>E-commerce page design</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div class="col-md-7 col-sm-7 col-xs-12">
                      <div class="product-image">
                            @php $img = $item->cover_image->image @endphp
                            <img src=' {{ url("public/images/medium/$img")}} ' />
                      </div>
                      <div class="product_gallery">
                        @foreach($item->images as $i)
                          <a href="javascript:void(0)" onclick="$('.product-image').html($(this).html())">
                            @php $img = $i->image @endphp
                            <img src=' {{ url("public/images/medium/$img")}} ' />
                          </a>
                        @endforeach
                      </div>
                    </div>

                    <div class="col-md-5 col-sm-5 col-xs-12" style="border:0px solid #e5e5e5;">

                      <h3 class="prod_title">LOWA Men’s Renegade GTX Mid Hiking Boots Review</h3>

                      <p>
                        Brand  : {{$item->brand}} <br />
                        Style  : {{$item->style}} <br />
                        Design : {{$item->design}} <br />
                        Fabric : {{$item->fabric}} <br />
                        Weight : {{$item->weight}} <br />
                        Description : {{$item->description}} <br />
                      </p>

                      <div class="">
                        <h2>Available Colors</h2>
                        <ul class="list-inline prod_color">
                          @foreach($item->colors() as $c)
                          <li>
                            <p>{{$c->color}}</p>
                            <div class="color bg-{{$c->color}}"></div>
                          </li>
                          @endforeach
                        </ul>
                      </div>
                      <br />

                      <div class="">
                        <h2>Available Size </h2>
                        <ul class="list-inline prod_size">
                          @foreach($item->sizes() as $s)
                          <li>
                            <button type="button" class="btn btn-default btn-xs">{{$s->size}}</button>
                          </li>
                          @endforeach
                        </ul>
                      </div>
                      <br />

                      <div class="">
                        <div class="product_price">
                          <h1 class="price">{{ $item->design_code }}</h1>
                          <br>
                        </div>
                      </div>


                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        <!-- /page content -->
@endsection