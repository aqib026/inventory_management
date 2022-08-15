                <div class="x_title">
                  <form action="" method="get" class="form-horizontal form-label-left">
                    <label class="control-label col-md-1 col-sm-3 col-xs-12">Filter</label>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                    @if(isset($search))
                    <input type="text" class="form-control" name="search" value="{{ $search }}" required autofocus>
                    @endif
                    </div>

                    <label class="control-label col-md-1 col-sm-3 col-xs-12">Filter By</label>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                    <select name="filter_by" class="form-control" required="" >
                      @if(isset($filter_by))
                      <option  value="{{$filter_by}}">{{$filter_by}}</option>
                      @endif
                      <option value="order_no">Order No</option>
                      <option value="customer_name">Customer Name</option>
                      <option value="customer_id">Customer Id</option>
                      <option value="sale_person">Sale Person</option>
                    </select>
                    <!--label class="control-label col-md-2 col-sm-3 col-xs-12">Filter</label-->
                    <input type="text" class="form-control input-sm" placeholder="Filter" id="search" name="search" value="{{ $search }}" autofocus style="display: none;">
                    </div>
                    
                    <div class="col-md-2 col-xs-12">
                    <select id="filter_status" name="filter_status" class="form-control input-sm" onchange="isDeliverd(this)">
                      <option value="" disabled="disabled">Status</option>
                      <option value="placed">Placed</option>
                      <option value="filled">Filled</option>
						@if($type != 'pending')
                      	<option value="dispatched">Dispatched</option>
                      	<option value="delivered">Delivered</option>
                      	<option value="canceled">Canceled</option>
                    	@endif  
                    </select>
                    
                    <div class="input-daterange input-group" id="datepicker" style="display: none">
    					<input type="text" class="input-sm form-control" name="start_delv" value="{{ $request->input('start_delv') }}" title="Delivered date from "/>
    					<span class="input-group-addon">to</span>
    					<input type="text" class="input-sm form-control" name="end_delv" value="{{ $request->input('end_delv') }}" title="Delivered date"/>
					</div>
                    </div>
                    
                    <div class="col-md-2 col-xs-12">
                    <input type="text" class="form-control input-sm" placeholder="Design Code" name="code" value="{{ $request->input('code') }}" autofocus>
                    </div>
                    
                    <div class="col-md-2 col-xs-12">
                    <input type="text" class="form-control input-sm" placeholder="Size" name="size" value="{{ $request->input('size') }}" autofocus>
                    </div>
                    
                    <div class="col-md-2 col-xs-12">
                    <input type="text" class="form-control input-sm" placeholder="Color" name="color" value="{{ $request->input('color') }}" autofocus>
                    </div>
					
                    <script type="text/javascript">
                    	document.getElementById('filter_by').value = '{{$filter_by}}';
                    	document.getElementById('filter_status').value = '{{$request->input("filter_status")}}';

                    	document.addEventListener("DOMContentLoaded", function(event) { 
                    	  //ready
                    	  	isSearch($('#filter_by').get(0));isDeliverd($('#filter_status').get(0));
                    	  	$('.input-daterange').datepicker({format:'yyyy-mm-dd',todayHighlight:true,clearBtn:true});
                    	});

                    	function isDeliverd(fStatus){
                        	if(fStatus.value == 'dispatched' || fStatus.value == 'delivered' ){
                            	$('#datepicker').show();
                        	}else{
                        		$('#datepicker').hide();
                            }
                    	}

                    	function isSearch(fsearch){
                    		if(fsearch.value){
                            	$('#search').show().attr('placeholder','Filter by '+fsearch.selectedOptions[0].text);
                        	}else{
                        		$('#search').hide();
                            }
                    	}
                    	
                    </script>
                    <style>
                        .datepicker.datepicker-dropdown.dropdown-menu {width: 250px;}
                    </style>
                    
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <input type="submit" value="Search" class="btn btn-success">
                      <a href="javascript:void(0)" onclick="window.location.search = '';" class="btn btn-info">Reset</a>
                    </div>
                    </div>
                    
                    
                  </form>
                </div>