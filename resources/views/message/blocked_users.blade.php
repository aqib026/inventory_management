@extends('layouts.app')

@section('content')
<div class="">

            <div class="page-title">
              <div class="title_left">
                <h3>Blocked Users  <small style="color: red;">
                </small></h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                 
                  <div class="x_content">
                  
                <div class="x_title">
                  
                </div>


                  <table id="table" class="hover table table-striped table-bordered dt-responsive nowrap" cellspacing="0" style="width: 100%">
                      <thead>
                        <tr>
                          <th>User ID</th>
                          <th>User Name</th>
                          <th>Status</th>
                          <th>Change Status</th>                       
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($users as $user)
                        @if($user->status == 'Blocked')
                        <tr>
                          <td>{{$user->user_id}}</td>
                          <td>{{$user->user_name}}</td>
                          <td>{{$user->status}}</td>
                          <td> 
                            <form action="" class="input-group" method="get" >
                              <div class="col-md-6">
                                    <select  class="form-control" id="status" name="status" required="yes">
                                        <option value="">Select</option>
                                        <option value="Active">Active</option>
                                        <option value="Blocked">Blocked</option>
                                     </select>
                                </div>
                                <div class="col-md-6">
                                  <input type="hidden" name="user_id" id="user_id" value="{{$user->user_id}}">
                                  <input style="margin-left: 20px; margin-bottom: 0px;" type="submit" id="{{$user->user_id}}" name="{{$user->user_id}}" value="Save" class="btn btn-success">
                                </div>

                            </form> </td>
                          </tr>
                        @endif
                        @endforeach
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
            </div>         
</div>
@endsection

@section('scripts')
<!-- datatable -->
 <script src="https://code.jquery.com/jquery-1.12.4.js" integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>

<script type="text/javascript" language="javascript">
    $(document).ready(function() {
      document.getElementById("date_to").defaultValue = new Date().toJSON().slice(0,10);
      document.getElementById("date_from").defaultValue = new Date().toJSON().slice(0,10);
      document.getElementById("type").value = "visit";
      document.getElementById("user_id").value = "5";
            $('#table').DataTable({
                "paging"  : true,
                "ordering": true,
                "info"    : false
            });
    });
    </script>
     <!-- datatable -->
@stop