@extends('layouts.app')

@section('content')
<center><div>
<img src="/public/dg8.gif" name="hr1"><img 
src="/public/dg8.gif" name="hr2"><img 
src="/public/dgc.gif"><img 
src="/public/dg8.gif" name="mn1"><img 
src="/public/dg8.gif" name="mn2"><img 
src="/public/dgc.gif"><img 
src="/public/dg8.gif" name="se1"><img 
src="/public/dg8.gif" name="se2"></div></center>
<script type="text/javascript">
dg = new Array();
dg[0]=new Image();dg[0].src="/public/dg0.gif";
dg[1]=new Image();dg[1].src="/public/dg1.gif";
dg[2]=new Image();dg[2].src="/public/dg2.gif";
dg[3]=new Image();dg[3].src="/public/dg3.gif";
dg[4]=new Image();dg[4].src="/public/dg4.gif";
dg[5]=new Image();dg[5].src="/public/dg5.gif";
dg[6]=new Image();dg[6].src="/public/dg6.gif";
dg[7]=new Image();dg[7].src="/public/dg7.gif";
dg[8]=new Image();dg[8].src="/public/dg8.gif";
dg[9]=new Image();dg[9].src="/public/dg9.gif";

function dotime(){ 
    var d=new Date();
    var hr=d.getHours(),mn=d.getMinutes(),se=d.getSeconds();

    document.hr1.src = getSrc(hr,10);
    document.hr2.src = getSrc(hr,1);
    document.mn1.src = getSrc(mn,10);
    document.mn2.src = getSrc(mn,1);
    document.se1.src = getSrc(se,10);
    document.se2.src = getSrc(se,1);
}

function getSrc(digit,index){
    return dg[(Math.floor(digit/index)%10)].src;
}

window.onload=function(){
    dotime();
    setInterval(dotime,1000);
}
</script>

<center>
    @if( $performance_d != null )

        <a style="font-size: 20px">Today's Hours : </a><a style="color: red; font-size: 70px">{{$performance_d}} &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</a> 
    @else
        <a style="font-size: 20px">Today's Hours : </a><a style="color: red; font-size: 70px">00:00:00 &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</a> 
    @endif
    @if( $performance_w != null )
        <a style="font-size: 20px">last 7 Days : </a><a style="color: green; font-size: 70px">{{$performance_w}}</a>
    @else
        <a style="font-size: 20px">last 7 Days : </a><a style="color: green; font-size: 70px">00:00:00</a>
    @endif
</center>



<div class="">
  <div class="page-title">
    <div class="title_left">

       
        <h2>Create a New Message </h2>
    </div>
  </div>
  <div class="clearfix"></div>

  <div class="row">

    <div class="col-md-4 col-xs-12">
    
      <div class="x_panel" style="height: 480px;width: 700px;">
        <div class="x_title">
              <h2></h2>
              
        
                                     
                <form id="demo-form2" action="{{ url('/save_message') }}" method="post" data-parsley-validate class="form-horizontal form-label-left">
                {!! csrf_field() !!}
                           
                         <div class="form-group row">
                            <label for="sale_type" class="col-md-8 col-sm-12 col-xs-12 col-form-label">Select Type</label>
                                <div class="col-sm-3">
                                    <select  class="form-control col-md-7 col-xs-12" id="sale_type" name="sale_type" required="yes">
                                        <option value="">Select</option>
                                        <option value="watsapp">Watsapp</option>
                                        <option value="email">Email</option>
                                        <option value="visit">visit</option>
                                     </select>
                                </div>
                        </div>
                         
                            <div class="form-group row">
                                <label for="customer_id" class="col-md-8 col-sm-12 col-xs-12 col-form-label">Customer ID</label>
                                <div class="col-sm-3">
                                    <input list="customer_id" name="customer_id" required>
                                    <datalist  class="col-md-7 col-xs-12" id="customer_id" name="customer_id">
                                        <option value="">Select</option>
                                        <option value="0">New Customer</option>
                                        @foreach($customers as $c)
                                            @if($c->status != "blocked")
                                            <option value="{{$c->customer_id}}">{{$c->customer_name}} {{$c->middle_name}} {{$c->last_name}}</option>
                                            @endif
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>


                            <div id="watsapp_div" style="display: none;">
                            <div class="form-group row" >
                                    <label for="watsapp" class="col-md-8 col-sm-12 col-xs-12 col-form-label">Watsapp</label>
                                    <div class="col-sm-3">
                                        <input type="watsapp" id="watsapp" name="watsapp" class=" col-md-7 col-xs-12 form-control">
                                </div>
                              </div></div>

                              <div id="email_div" style="display: none;">
                              <div class="form-group row" >
                                    <label for="email" class="col-md-8 col-sm-12 col-xs-12 col-form-label">Email</label>
                                    <div class="col-sm-3">
                                        <input type="text" id="email" name="email" class=" col-md-7 col-xs-12 form-control">
                                </div>
                              </div></div>

                            
                            <div id="new_customer_details_div" style="display: none;">
                             <div class="form-group row" >
                                    <label for="customer_name" class="col-md-8 col-sm-12 col-xs-12 col-form-label">Customer Name</label>
                                    <div class="col-sm-3">
                                        <input type="text" id="customer_name" name="customer_name" class=" col-md-7 col-xs-12 form-control">
                                </div>
                              </div>

                               <div class="form-group row">
                                    <label for="phone" class="col-md-8 col-sm-12 col-xs-12 col-form-label">Phone</label>
                                    <div class="col-sm-3">
                                        <input type="text" id="phone" name="phone" class=" col-md-7 col-xs-12 form-control">
                                </div>
                              </div>
                            </div>


                                <div class="form-group row">
                                    <label for="message" class="col-md-8 col-sm-12 col-xs-12 col-form-label">Message</label>
                                    <div class="col-sm-3">
                                        <!--<input type="text" id="message" name="message" class=" col-md-7 col-xs-12 form-control" required="yes">-->
                                        <textarea rows="4" cols="50" id="message" name="message" col-md-7 col-xs-12 form-control" required="yes"></textarea>
                                </div>
                              </div>

                                <div class="form-group row">
                                    <label for="time" class="col-md-8 col-sm-12 col-xs-12 col-form-label">Time (in minutes)</label>
                                    <div class="col-sm-3">
                                        <input type="text" id="time" name="time" class=" col-md-7 col-xs-12 form-control" required="yes">
                                </div>
                                </div>

                                <div class="form-group row">
                                    <label for="orders_recieved" class="col-md-8 col-sm-12 col-xs-12 col-form-label">Orders Recieved</label>
                                    <div class="col-sm-3">
                                        <input type="text" id="orders_recieved" name="orders_recieved" class=" col-md-7 col-xs-12 form-control" required="yes">
                                </div>
                                </div>
                            
                           
                            <div class="form-group row">
                                <label for="payment_recieved" class="col-md-8 col-sm-12 col-xs-12 col-form-label">Payment Recieved</label>
                                <div class="col-sm-3">
                                    <select  class="form-control col-md-7 col-xs-12" id="payment_recieved" name="payment_recieved" required="yes">
                                       <option value="">Select</option>
                                       <option value="yes">Yes</option>
                                       <option value="No">No</option>
                                       
                                    </select>
                                </div>
                            </div>


                            
                            <div id="amount_div" style="display: none;">
                                <div class="form-group row">
                                    <label for="amount" class="col-md-8 col-sm-12 col-xs-12 col-form-label">Amount Collected</label>
                                    <div class="col-sm-3">
                                        <input type="text" id="amount" name="amount" class="form-control col-md-7 col-xs-12">
                                </div>

                            </div></div>
                               
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <input type="Submit" id="save_message" class="btn btn-success" value="Submit" style="margin-left: 20%">
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