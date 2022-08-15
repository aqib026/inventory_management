                <div class="x_title">
                  <form action="" method="get" class="form-horizontal form-label-left">
                    

                    <label class="control-label col-md-1 col-sm-3 col-xs-12">Filter By</label>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                    <select name="filter_by" class="form-control" required="" >
                      @if(isset($filter_by))
                      <option  value="{{$filter_by}}">{{$filter_by}}</option>
                      @else
                      <option  value="">Select</option>
                      @endif
                      <option value="message_id">Message ID</option>
                      <option value="customer_id">Customer ID</option>
                      <option value="customer_name">Customer Name</option>
                      <option value="date">Date</option>
                      <option value="user">User</option>
                      <option value="type">type</option>
                    </select>
                    </div>


                     <label class="control-label col-md-1 col-sm-3 col-xs-12">User</label>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                    <select name="user_id" class="form-control" >
                      <option  value="">Select</option>
                      @foreach($users as $user)
                      <option value="{{$user->member_id}}">{{$user->member_id}} --> {{$user->username}}</option>
                      @endforeach
                    </select>
                    </div>



                    <label class="control-label col-md-1 col-sm-3 col-xs-12">Type</label>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                    <select name="type" class="form-control" >
                        <option  value="">Select</option>
                        <option value="watsapp">Watsapp</option>
                        <option value="email">Email</option>
                        <option value="visit">visit</option>
                    </select>
                    </div>

                    <label class="control-label col-md-1 col-sm-3 col-xs-12">Date</label>
                    <div class="input-group date" data-provide="datepicker" style="width: 150px;">
                      <input type="date" class="form-control" id="date" name="date" >
                      <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                      </div>
                    </div>

                   
                    <div class="col-md-2 col-sm-6 col-xs-12" style="margin-left: 368px;">
                      <input type="submit" value="Search" class="btn btn-success">
                      <a href="{{ url('/view_messages') }}" class="btn btn-info">Reset</a>
                    </div>

                  </form>
                </div>