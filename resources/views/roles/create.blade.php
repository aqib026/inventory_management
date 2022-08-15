@extends('layouts.app')

@section('content')
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Roles <small>Add New Role</small></h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                  <div class="x_content">

                  {!! Form::model($model, ['route' => ['roles.store'],'method'=>'post']) !!}

                  {!! Form::label('name', 'Unique Name')  !!}
                  {!! Form::text('name', '', ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('display_name', 'Display Name')  !!}
                  {!! Form::text('display_name', '', ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('description', 'Description')  !!}
                  {!! Form::text('description', '', ['class' => 'form-control','required' => 'required'])  !!}

                  
                    <div class="col-offset-6 col-sm-6 center top10" style="margin-top: 10px;">
                      {!!  Form::submit('Create a Role',['class' => 'btn btn-success'])  !!}
                    </div>

                  {!! Form::close() !!}
          
                  </div>
                </div>
              </div>
            </div>         
</div>
@endsection
