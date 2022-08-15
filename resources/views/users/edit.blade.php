@extends('layouts.app')

@section('content')
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Users <small>Update user</small></h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="x_panel">
                  <div class="x_content">

                    {!! Form::model($model, ['route' => ['users.update',$model->member_id], 'method' => 'patch']) !!}

                  {!! Form::label('name', 'Unique Name')  !!}
                  {!! Form::text('name',$model->name, ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('username', 'Username')  !!}
                  {!! Form::text('username',$model->username, ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('email', 'Email Address')  !!}
                  {!! Form::text('email',$model->email, ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('password', 'Password')  !!}
                  {!! Form::password('password', ['class' => 'form-control'])  !!}

                  {!! Form::label('active', 'Status')  !!}
                  {!! Form::select('active',[0=>'Inactive',1=>'Active'],$model->active, ['class' => 'form-control','required' => 'required'])  !!}

                  {!! Form::label('role', 'Role')  !!}
                  @if( isset($model->roles[0]) )
                  {!! Form::select('role',$roles,$model->roles[0]->id, ['class' => 'form-control','required' => 'required'])  !!}
                  @else
                  {!! Form::select('role',$roles,'', ['class' => 'form-control','required' => 'required'])  !!}
                  @endif

                  @if( isset($model->roles[0]) && $model->roles[0]->name == 'dropshipper')
                    {!! Form::label('assign_customer', 'Assign Customer')  !!}
                    {!! Form::select('assign_customer',$customers,$model->assign_customer, ['class' => 'form-control'])  !!}
                  @endif                  

                  
                    <div class="col-offset-6 col-sm-6 center top10" style="margin-top: 10px;">
                      {!!  Form::submit('Update User',['class' => 'btn btn-success'])  !!}
                    </div>

                  {!! Form::close() !!}
          
                  </div>
                </div>
              </div>
            </div>         
</div>
@endsection
