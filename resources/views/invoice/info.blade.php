    <div class="col-xs-4">
      <p><strong>{{$order->customer->business_name}}</strong></p>
      @if( Auth::user()->can('view_customer') )
      <p><b>Contact Person</b>&nbsp;&nbsp;&nbsp;{{$order->customer->customer_name}} {{$order->customer->middle_name}} {{$order->customer->last_name}}</p>
      <p><b>Address</b>&nbsp;&nbsp;&nbsp;
      @if($order->delivery_add_id == 0)
      {{$order->customer->customer_add}} {{$order->customer->city}} {{$order->customer->postcode}} {{$order->customer->country}},{{$order->customer->mob_no}} {{$order->customer->office_no}}</p>
      @else
      {{$order->del_address->fname}} {{$order->del_address->mname}} {{$order->del_address->lname}}, {{$order->del_address->address}}, {{$order->del_address->city}}, {{$order->del_address->postcode}}, {{$order->del_address->mobile_no}}, {{$order->del_address->country}} </p>
      @endif
      @endif
    </div>
    
    <div class="col-xs-4">
      <p><b>Order #</b>&nbsp;&nbsp;&nbsp;{{$order->order_no}}</p>
      <p><b>Order Date</b>&nbsp;&nbsp;&nbsp;{{$order->order_date}}</p>
      @if( Auth::user()->can('view_customer') )
      <p><b>Sale Person</b>&nbsp;&nbsp;&nbsp;{{$order->sale_person}}</p>      
      @endif
      <p><b>VAT : </b>&nbsp;&nbsp;&nbsp;        
        @if($order->company->name == 'GFL INTERNATIONAL LIMITED')
          225 1907 24
        @else
          859 1702 04
        @endif</p>      
    </div>
    <div class="col-xs-4">
      
    </div>