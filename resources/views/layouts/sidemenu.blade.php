        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="{{ url('/') }}" class="site_title"><i class="fa fa-paw"></i> <span>INVENTORY!</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{ Auth::user()->name }}</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>

                <ul class="nav side-menu">

                  @if( Auth::user()->can('make_sales') )
                  <li><a><i class="fa fa-sitemap"></i> Sales <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('/sales') }}">Sales</a></li>                      
                    </ul>
                  </li>
                  @endif

                <ul class="nav side-menu">
                  @if( Auth::user()->can('manage_order') )
                  <li><a><i class="fa fa-table"></i> Order <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      @if( Auth::user()->can('manage_hawavee_order') )
                      <li><a href="{{ url('/expenses') }}">Add Expenses</a></li>
                      <li><a href="{{ url('/expense_report') }}">Expenses Report</a></li>
                      <li><a href="{{ url('/hawavee_pending_orders?ostatus=dispatched') }}">Dispatched Hawawee Orders</a></li>
                      <li><a href="{{ url('/hawavee_pending_orders') }}">Pending Hawawee Orders</a></li>
                      <li><a href="{{ url('/hawavee_orders') }}">Hawawee Orders</a></li>
                      @if(!Entrust::hasRole('dropshipper'))
                      <li><a href="{{ url('/cumulative') }}">Cumulative Packing List</a></li>
                      @endif
                      @endif
                      @if( Auth::user()->can('salesman_commission') )
                      <li><a href="{{ url('/commission') }}">Orders Commissions</a></li>
                      @endif
                      @if( Auth::user()->can('manage_ebay_order') )
                      <li><a href="{{ url('/ebay_orders') }}">Ebay Orders</a></li>
                      @endif
                      @if( Auth::user()->can('manage_fws_order') )
                      <li><a href="{{ url('/fws_orders') }}">FWS Orders</a></li>
                      @endif
                    </ul>
                  </li>
                </ul>
                @endif
                
                @if( Auth::user()->can('manage_customer') )
                  <li><a><i class="fa fa-bug"></i> Customers <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      @if( Auth::user()->can('view_uk_customer') )
                      <li><a href="{{ url('/customers/?c=UK') }}">UK Customers</a></li>
                      @endif
                      @if( Auth::user()->can('view_pk_customer') )
                      <li><a href="{{ url('/customers/?c=Pak') }}">PAK Customers</a></li>
                      @endif
                    </ul>
                  </li>
                  @endif
                  @if( Auth::user()->can('manage_item') )
                  <li><a><i class="fa fa-windows"></i> Inventory <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('/home') }}">Items</a></li>
                      <li><a href="{{ url('/home?wh=PK') }}">Paki Items</a></li>
                      <li><a href="{{ url('/home?wh=UK') }}">UK Items</a></li>
                      @if(Entrust::hasRole('owner') || Entrust::hasRole('buyer'))
                      <li><a href="{{ url('/repeating') }}">Repeating Items</a></li>
                      @endif
                      <li><a href="{{ url('/colors') }}">Colors</a></li>
                      @if( Auth::user()->can('manage_ebay') )
                      <li><a href="{{ url('/ebay_templates') }}">Ebay Templates</a></li>
                      @endif
                    </ul>
                  </li>
                  @endif
                  @if( Auth::user()->can('manage_purchase_order') )
                  <li><a><i class="fa fa-home"></i> Purchase Orders <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('/purchase') }}">New Purchase Order</a></li>
                      <li><a href="{{ url('/purchase_list') }}">All Purchase Order</a></li>
                      <li><a href="{{ url('/purchase_placed') }}">Placed Purchase Order</a></li>
                    </ul>
                  </li>
                   @endif
                  </ul>

                @if( Auth::user()->can('manage_payment') )
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-clone"></i> Payments <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('/pending_payments') }}">Pending Payments</a></li>
                      <li><a href="{{ url('/received_payments') }}">Received Payments</a></li>
                    </ul>
                  </li>
                </ul>
                @endif
                @if(Entrust::hasRole('owner'))
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-clone"></i> Users <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('/users') }}">Users</a></li>
                      <li><a href="{{ url('/roles') }}">Roles</a></li>
                      <li><a href="{{ url('/permissions') }}">Permissions</a></li>
                    </ul>
                  </li>
                </ul>
                @endif     


                @if(!Entrust::hasRole('supplier') && !Entrust::hasRole('dropshipper'))
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-envelope-o"></i> Messages <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ url('/message') }}">Create Message</a></li>
                      <li><a href="{{ url('/view_messages') }}">View Messages</a></li>
                      @if(Entrust::hasRole('owner'))
                      <li><a href="{{ url('/report') }}">Report</a></li>
                      <li><a href="{{ url('/user_report') }}">User Report</a></li>
                      <li><a href="{{ url('/blocked_customers') }}">Blocked Customers</a></li>
                      <li><a href="{{ url('/blocked_users') }}">Blocked Users</a></li>
                      @endif  
                    </ul>
                  </li>
                </ul>
                @endif 
                



              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <form method="post" action="{{ url('/logout') }}">
              {{ csrf_field() }}
                <button type="submit" data-toggle="tooltip" data-placement="top" title="Logout">
                  <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                </button> 
              </form>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>