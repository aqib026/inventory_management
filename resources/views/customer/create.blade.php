@extends('layouts.app')

@section('content')
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Customers <small>Add New Customer</small></h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                  <div class="x_content">

                  {!! Form::model($model, ['route' => ['customers.store']]) !!}

                  {!! Form::label('customer_name', 'Name')  !!}
                  {!! Form::text('customer_name', '', ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('middle_name', 'Middle Name')  !!}
                  {!! Form::text('middle_name', '', ['class' => 'form-control'])  !!}

                  {!! Form::label('last_name', 'Last Name')  !!}
                  {!! Form::text('last_name', '', ['class' => 'form-control'])  !!}

                  {!! Form::label('business_name', 'Business Name')  !!}
                  {!! Form::text('business_name', '', ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('customer_add', 'Address')  !!}
                  {!! Form::textarea('customer_add', '', ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('city', 'City')  !!}
                  {!! Form::text('city', '', ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('country', 'Country')  !!}
                  {!! Form::select('country', ['UK' => 'United Kingdom', 'Pak' => 'Pakistan'],null, ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('postcode', 'Postcode')  !!}
                  {!! Form::text('postcode', '', ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('mob_no', 'Mobile No')  !!}
                  {!! Form::text('mob_no', '', ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('office_no', 'Office No')  !!}
                  {!! Form::text('office_no', '', ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('email', 'Email Address')  !!}
                  {!! Form::email('email', '', ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('vat', 'VAT')  !!}
                  {!! Form::select('vat',[1 => 'Yes',0 => 'No'],'', ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('user', 'Sale Person')  !!}
                  {!! Form::select('user',$users,'', ['class' => 'form-control','required' => 'required'])  !!}

                    <div class="col-offset-6 col-sm-6 center top10" style="margin-top: 10px;">
                      {!!  Form::submit('Add Customer',['class' => 'btn btn-success'])  !!}
                    </div>

                  {!! Form::close() !!}
          
                  </div>
                </div>
              </div>
            </div>         
</div>
@endsection
