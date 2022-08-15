        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              
              

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="images/img.jpg" alt="">{{ Auth::user()->name }}
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href=" {{ url('/profile') }}"> Profile</a></li>
                    <li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                    </li>
                    <li><a href="javascript:;">Help</a></li>
                    <li><form method="post" action="{{ url('/logout') }}">
                    {{ csrf_field() }}
                    <button type="submit" style="background-color: #fff; border: none; margin-left:13px; color: #5A738E;" data-toggle="tooltip" data-placement="top" title="Logout">Log Out</button> <i class="fa fa-sign-out pull-right" style="margin-right: 15px;"></i></form></li>
                  </ul>
                </li>
                <li>
                  @if( Auth::user()->can('make_sales') )
                  <a href="{{ url('/sales') }}" class="btn btn-warning" style="color: #fff !important; padding: 3px 22px; margin-top:8px;">Sales</a>
                  @endif
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->