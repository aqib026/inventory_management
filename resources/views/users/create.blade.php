@extends('layouts.app')

@section('content')
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Users <small>Add New user</small></h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                  <div class="x_content">

                  {!! Form::model($model, ['route' => ['users.store'],'method'=>'post']) !!}

                  {!! Form::label('name', 'Unique Name')  !!}
                  {!! Form::text('name', '', ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('username', 'Username')  !!}
                  {!! Form::text('username', '', ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('email', 'Email Address')  !!}
                  {!! Form::text('email', '', ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('password', 'Password')  !!}
                  {!! Form::password('password', ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('role', 'Role')  !!}
                  {!! Form::select('role',$roles,'', ['class' => 'form-control','required' => 'required'])  !!}

                  
                    <div class="col-offset-6 col-sm-6 center top10" style="margin-top: 10px;">
                      {!!  Form::submit('Create a User',['class' => 'btn btn-success'])  !!}
                    </div>

                  {!! Form::close() !!}
          
                  </div>
                </div>
              </div>
            </div>         
</div>
@endsection
