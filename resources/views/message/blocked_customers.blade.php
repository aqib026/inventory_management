@extends('layouts.app')

@section('content')
<div class="">

            <div class="page-title">
              <div class="title_left">
                <h3>Blocked Customers  <small style="color: red;">
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
                          <th>Customer ID</th>
                          <th>Customer Name</th>
                          <th>Blocked On</th>
                          <th>Block Days</th>
                          <th>Status</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($customers as $customer)
                        <tr>
                          <td>{{$customer->customer_id}}</td>
                          <td>{{$customer->customer_name}}</td>
                          <td>{{$customer->created_at}}</td>
                          <td width="80"> <form action="" class="input-group" method="get" >
                            <div style="margin-left: 20px;" class="col-md-6 input-group date" >

                              <input type="text" class="form-control" id="days" value="{{$customer->block_days}}" name="days" required="" style="width: 70px;">
                                  <div class="input-group-addon">
                                    <i class="glyphicon glyphicon-th"></i>
                                  </div>

                                <div class="col-md-6">
                                  <input type="hidden" name="customer_id" id="customer_id" value="{{$customer->customer_id}}">
                                  <input style="margin-left: 20px; margin-bottom: 0px;" type="submit" id="{{$customer->customer_id}}" name="{{$customer->customer_id}}" value="Save" class="btn btn-success">
                                </div>
                              
                              </div>
                              
                                </form> </td>
                          <td>{{$customer->status}}</td>
                        </tr>
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