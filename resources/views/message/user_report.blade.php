@extends('layouts.app')

@section('content')
<div class="">

 
            <div class="page-title">
              <div class="title_left">
                <h3>Message  <small style="color: red;">
                </small></h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                 
                  <div class="x_content">
                  
                <div class="x_title">
                  <form action="" method="get" class="form-horizontal form-label-left">
                    
                   
                     <label class="control-label col-md-1 col-sm-3 col-xs-12">User</label>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                    <select name="user_id" id="user_id" class="form-control" required="" >
                      <option  value="">Select</option>
                      @foreach($users as $user)
                      <option value="{{$user->member_id}}">{{$user->member_id}} --> {{$user->username}}</option>
                      @endforeach
                    </select>
                    </div>

                    
                     <label class="control-label col-md-1 col-sm-3 col-xs-12">Type</label>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                    <select name="type" id="type" class="form-control" required="yes" >
                        <option  value="">Select</option>
                        <option value="watsapp">Watsapp</option>
                        <option value="email">Email</option>
                        <option value="visit">visit</option>                       
                    </select>
                    </div>


                    <label class="control-label col-md-1 col-sm-3 col-xs-12">Date From</label>
                    <div class="col-md-2 col-sm-6 col-xs-12 input-group date" data-provide="datepicker" style="width: 100px;">
                      <input type="date" class="form-control" id="date_from" name="date_from" required="">
                      <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                      </div>
                    </div>

                    
                    <label class="control-label col-md-1 col-sm-3 col-xs-12">Date To</label>
                    <div class=" input-group date" data-provide="datepicker" style="width: 100px;">
                      <input type="date" class="form-control" id="date_to" name="date_to" required="">
                      <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                      </div>
                    </div>
                  
                   <br><center>
                    <div class="" style="">
                      <input type="submit" value="Search" class="btn btn-success">
                    </div></center>

                  </form>
                </div>


                  <table id="table" class="hover table table-striped table-bordered dt-responsive nowrap" cellspacing="0" style="width: 100%">
                      <thead>
          @if(isset($type))
                @if($type=="visit")
                        <tr>
                          <th>Date</th>
                          <th>Working Time</th>
                          <th>Customers Visited</th>
                          <th style="color: #337ab7;">Orders (User)</th>

                          <th style="color: #1abb9c;">Orders</th>

                          <th style="color: #337ab7;">Cash (User)</th>

                          <th style="color: #1abb9c;">Cash</th>

                          <th style="color: red">Cash Per Visit</th>
                          <th style="color: red">Order Per Visit</th>
                          <th style="color: red">Time Per Visit</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if(isset($messages))
                      @foreach ($messages as $message)
                        <tr>
                          <td>{{$message->by_date}}</td>
                          <td>{{$message->working_time}}</td>
                          <td>{{$message->customers_visited}}</td>
                          <td style="color: #337ab7;">{{$message->orders}}</td>

                          <?php $flag=0;?>
                          @foreach($orders as $order)
                            @if($order->order_date == $message->by_date)
                              <?php $flag=1;?>
                              <td style="color: #1abb9c;">{{$order->no_of_orders}}</td>
                              <?php break;?>
                            @endif
                          @endforeach
                          @if($flag==0)
                            <td></td>
                          @endif

                          <td style="color: #337ab7;">{{$message->cash}}</td>

                         <?php $flag=0;?>
                         @foreach($orders as $order)
                            @if($order->order_date == $message->by_date)
                              <?php $flag=1;?>
                              <td style="color: #1abb9c;">{{$order->amount}}</td>
                              <td style="color: red">{{number_format($order->amount/$message->customers_visited,2)}}</td>
                              <td style="color: red">{{number_format($order->no_of_orders/$message->customers_visited,2)}}</td>
                              <?php break;?>
                            @endif
                          @endforeach
                          @if($flag==0)
                            <td></td>
                            <td></td>
                            <td></td>
                          @endif

                          
                          <td style="color: red">{{$message->per_time}}</td>
                        </tr>
                      @endforeach 
                      @endif

                @elseif($type=="email")
                        <tr>
                          <th>Date</th>
                          <th>Working Time</th>
                          <th>Emails</th>
                          <th style="color: #337ab7;">Orders Recieved</th>
                          <th style="color: #1abb9c;">Cash Collected</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if(isset($messages))
                      @foreach ($messages as $message)
                        <tr>
                          <td>{{$message->by_date}}</td>
                          <td>{{$message->working_time}}</td>
                          <td>{{$message->email}}</td>
                          <td style="color: #337ab7;">{{$message->orders}}</td>
                          <td style="color: #1abb9c;">{{$message->cash}}</td>
                        </tr>
                      @endforeach 
                      @endif

                @elseif($type=="watsapp")
                        <tr>
                          <th>Date</th>
                          <th>Working Time</th>
                          <th>Watsapp</th>
                          <th style="color: #337ab7;">Orders Recieved</th>
                          <th style="color: #1abb9c;">Cash Collected</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if(isset($messages))
                      @foreach ($messages as $message)
                        <tr>
                          <td>{{$message->by_date}}</td>
                          <td>{{$message->working_time}}</td>
                          <td>{{$message->watsapp}}</td>
                          <td style="color: #337ab7;">{{$message->orders}}</td>
                          <td style="color: #1abb9c;">{{$message->cash}}</td>
                        </tr>
                      @endforeach 
                      @endif
                @endif
          @endif
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