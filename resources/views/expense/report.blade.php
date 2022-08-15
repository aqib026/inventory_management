@extends('layouts.app')

@section('content')
<div class="">

 
            <div class="page-title">
              <div class="title_left">
                <h3>Expense Report  <small style="color: red;">
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
                    <div>
                    <label class="control-label col-md-1 col-sm-3 col-xs-12">Date</label>
                    <div class="col-md-2 col-sm-6 col-xs-12 input-group date" data-provide="datepicker" style="width: 100px;">
                      <input type="date" class="form-control" id="date" name="date" required="">
                      <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                      </div>
                      
                    </div>

                    <input type="submit" value="Search" class="btn btn-success">
                   
                      
                    </div>

                  </form>
                </div>


                  <table id="table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" style="width: 100%">
                      <thead>
                 @if( isset($report) )
                        <tr>
                          <th>Date</th>
                          <th>Design Code</th>
                          <th>No of Orders</th>
                          <th>Quantity</th>
                          <th>Price</th>
                          <th>Cost</th>
                          <th>Profit</th>
                          <th>order_status</th>
                         
                        </tr>
                      </thead>
                      <?php $total_profit=0; 
                            $total_expense=0; 
                            $total_cost=0;
                            $total_sale=0;
                            $remaining_profit=0;
                            $date=0;?>

                      <tbody>
                   
                      @foreach ($report as $r)
                          <?php $total_profit = $total_profit + $r->profit; 
                                $total_cost = $total_cost + $r->cost; 
                                $total_sale = $total_sale + $r->price;
                                $date = $r->delivered_date;?>
                        <tr>
                          <td>{{$r->delivered_date}}</td>
                          <td>{{$r->design_code}}</td>
                          <td>{{$r->no_of_orders}}</td>
                          <td>{{$r->quantity}}</td>
                          <td>{{$r->price}}</td>
                          <td>{{$r->cost}}</td>
                          <td>{{$r->profit}}</td>
                          <td>{{$r->order_status}}</td>

                        </tr>
                      @endforeach 

                    @endif
                      </tbody>
                    </table>
@if( isset($report) )
                      <h3>Total Cost = <?php echo $total_cost;?> </h3>
                      <h3>Total Sale = <?php echo $total_sale;?> </h3>
                      <h3>Total profit = <?php echo $total_profit;?> </h3>

                      @if(isset($expenses)) 
                      <h3>Total Expenses = {{$expenses->expense_amount}}</h3>
                      <?php $total_expense = $expenses->expense_amount;
                      $remaining_profit = $total_profit - $total_expense;?>

                      @else
                      <h3>Total Expenses = 0</h3> <p style="text-align: right;"> No Expenses found for <?php echo $date; ?></p>
                      <?php $remaining_profit = $total_profit;?>
                      @endif

                      <h3>Remaining Profit = <?php echo $remaining_profit;?></h3>
  @endif
                  

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
      
            $('#table').DataTable({
                "paging"  : true,
                "ordering": true,
                "info"    : false
            });
    });
    </script>
     <!-- datatable -->
@stop