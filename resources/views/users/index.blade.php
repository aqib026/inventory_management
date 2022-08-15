@extends('layouts.app')

@section('content')
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Users <small>Manage Users</small></h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div>
                    <div class="x_tittle">
                  <form action="" method="get" class="form-horizontal form-label-left">
                    
                    <label class="control-label col-md-1 col-sm-3 col-xs-12">Filter</label>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" name="search" value="{{ $search }}" required autofocus>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <input type="submit" value="Search" class="btn btn-success">
                      <a href="{{ url('/users') }}" class="btn btn-info">Reset</a>
                    </div>
                  </form>
                      <a class="btn btn-success" href='{{ url("/users/create")}}' style="float: right;" >Add User</a>
                    </div>
                  </div>
                  <div class="x_content">
                  {!! $users->appends(Input::except('page'))->links() !!}
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Username</th>
                          <th>E-mail Address</th>
                          <th>Active</th>
                          <th>Options</th>
                        </tr>
                      </thead>
                      <tbody>

                      @foreach ($users as $key => $u)
                        <tr>
                          <td>{{ $u->member_id }}</td>
                          <td>{{ $u->name }}</td>
                          <td>{{ $u->username }}</td>
                          <td>{{ $u->email }}</td>
                          <td>{{ $u->active }}</td>
                          <td>
                          <a href='{{ url("/users/$u->member_id/edit") }}'><span class="glyphicon glyphicon-pencil"></span></a>
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>
                  {!! $users->appends(Input::except('page'))->links() !!}
          
          
                  </div>
                </div>
              </div>
            </div>         
</div>
@endsection
