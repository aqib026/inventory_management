@extends('layouts.app')

@section('content')
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Enter Expenses <bold></bold></h3>
    </div>
  </div>
  <div class="clearfix"></div>

  <div class="row">

    <div class="col-md-4 col-xs-12">
    
      <div class="x_panel" style="width: 700px;">
        <div class="x_title">
              <h2></h2>
              
        
                                     
                <form id="demo-form2" action="{{ url('/save_expense') }}" method="post" data-parsley-validate class="form-horizontal form-label-left">
                {!! csrf_field() !!}
                           
                         
                         
                        <div class="form-group row">
                            <label class="control-label col-md-2">Date</label>
                            <div class="input-group date col-sm-3" data-provide="datepicker" style="width: 150px;padding-left: 10px;">
                                <input type="date" class="col-md-7 col-xs-12 form-control" id="date" name="date" >
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="expense_detail" class="control-label col-md-2">Expenses Detail</label>
                            <div class="col-sm-3">
                                <textarea rows="4" cols="50" id="expense_detail" name="expense_detail" col-md-7 col-xs-12 form-control" required="yes"></textarea>
                            </div>
                        </div>
                                                    
                            
                       
                        <div class="form-group row" >
                            <label for="expense_amount" class="control-label col-md-2">Expense Amount</label>
                            <div class="col-sm-3">
                                <input type="text" id="expense_amount" name="expense_amount" class="col-md-7 col-xs-12 form-control">
                            </div>
                        </div>

                          
                               
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <input type="Submit" id="save_expense" class="btn btn-success" value="Submit" style="margin-left: 20%">
                                </div>
                            </div>

                        </form>
               
          <div class="clearfix"></div>
        </div>
        

    </div>
              </div>  <!-- CLOSING OF COL_MD_6 -->

    <div class="col-md-8 col-xs-12" id="items_lists">
      


    </div>          
            </div>         
</div>
@endsection

@section('scripts')
  <script type="text/javascript">
     $(document).ready(function () {
        document.getElementById("date").defaultValue = new Date().toJSON().slice(0,10);

        $("#payment_recieved").change(function () {
            var type = $("#payment_recieved").val();
            //alert(type);  
            if (type == "yes")
            {
                $("#amount_div").show();
                document.getElementById("amount").required = true;
            } 
            else
            {
              $("#amount_div").hide();
              document.getElementById("amount").required = false;
            }

        }).change();


        $("#customer_id").change(function () {
            var type = $("#customer_id").val();
            //alert(type);  
            if (type == "0")
            {
                $("#new_customer_details_div").show();
                document.getElementById("customer_name").required = true;
                document.getElementById("phone").required = true;
            } 
            else
            {
                $("#new_customer_details_div").hide();
                document.getElementById("customer_name").required = false;
                document.getElementById("phone").required = false;
            }

        }).change();


        $("#sale_type").change(function () {
            var type = $("#sale_type").val();
            //alert(type);  
            if (type == "visit")
            {
                $("#email_div").hide();
                $("#watsapp_div").hide(); 
                document.getElementById("email").required = false;
                document.getElementById("watsapp").required = false;
            } 
            else if(type == "email")
            {
                $("#email_div").show();
                $("#watsapp_div").hide();   
                document.getElementById("email").required = true; 
                document.getElementById("watsapp").required = false;
            }
            else if(type == "watsapp")
            {
                $("#watsapp_div").show();
                $("#email_div").hide();  
                document.getElementById("watsapp").required = true;  
                document.getElementById("email").required = false;
            }
            else
            {
              $("#email_div").hide();
              $("#watsapp_div").hide(); 
              document.getElementById("email").required = false;
              document.getElementById("watsapp").required = false;
            }

        }).change();

  });
  </script>
@stop