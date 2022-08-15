@extends('layouts.app')

@section('content')
<div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Permission <small>Manage Permission</small></h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div>
                    <div class="x_tittle">
                      <a class="btn btn-success" href='{{ url("/permissions/create")}}' style="float: right;" >Add Permission</a>
                    </div>
                  </div>
                  <div class="x_content">
                  {!! $roles->appends(Input::except('page'))->links() !!}
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Display Name</th>
                          <th>Description</th>
                          <th>Updated Date</th>
                          <th>Options</th>
                        </tr>
                      </thead>
                      <tbody>

                      @foreach ($roles as $key => $r)
                        <tr>
                          <td>{{ $r->id }}</td>
                          <td>{{ $r->name }}</td>
                          <td>{{ $r->display_name }}</td>
                          <td>{{ $r->description }}</td>
                          <td>{{ $r->updated_at }}</td>
                          <td>
                          <a href='{{ url("/permissions/$r->id/edit") }}'><span class="glyphicon glyphicon-pencil"></span></a>
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>
                  {!! $roles->appends(Input::except('page'))->links() !!}
          
          
                  </div>
                </div>
              </div>
            </div>         
</div>
@endsection
