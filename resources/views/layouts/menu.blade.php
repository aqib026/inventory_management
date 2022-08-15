<div class="container" id="items_menu">
  <nav class="navbar navbar-default">
    <div class="collapse navbar-collapse js-navbar-collapse">
      <ul class="nav navbar-nav">
        @foreach($cats as $cat)
        <li class="dropdown mega-dropdown" style="display: inline !important; width: 200px !important;">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $cat->cat_name }} <span class="glyphicon glyphicon-chevron-down pull-right"></span></a>
          <ul class="dropdown-menu mega-dropdown-menu row">
           @foreach($cat->child as $ct )
            <li class="col-sm-3">
              <ul>
                <li class="dropdown-header">{{ $ct->cat_name }}</li>
                  @foreach($ct->child as $c )               
                    <li><a href=' {{ url("/listing?cat_id=$c->cat_id") }} '>{{ $c->cat_name }}</a></li>
                  @endforeach               
              </ul>
            </li>
            @endforeach
          </ul>

        </li>
        @endforeach
      </ul>

    </div>
    <!-- /.nav-collapse -->
  </nav>
</div>



@section('scripts')
<style>
@import url(http://fonts.googleapis.com/css?family=Open+Sans:400,700);

#items_menu .navbar-nav>li>.dropdown-menu {
  margin-top: 20px !important;
  border-top-left-radius: 4px !important;
  border-top-right-radius: 4px !important;
}

#items_menu .navbar-default .navbar-nav>li>a {
  width: 200px !important;
  font-weight: bold !important;
}

#items_menu .mega-dropdown {
  position: static !important;
  width: 100% !important;
}

#items_menu .mega-dropdown-menu {
  padding: 20px 0px !important;
  width: 100% !important;
  box-shadow: none !important;
  -webkit-box-shadow: none !important;
}

#items_menu .mega-dropdown-menu:before {
  content: "" !important;
  border-bottom: 15px solid #fff !important;
  border-right: 17px solid transparent !important;
  border-left: 17px solid transparent !important;
  position: absolute !important;
  top: -15px !important;
  left: 285px !important;
  z-index: 10 !important;
}

#items_menu .mega-dropdown-menu:after {
  content: "" !important;
  border-bottom: 17px solid #ccc !important;
  border-right: 19px solid transparent !important;
  border-left: 19px solid transparent !important;
  position: absolute !important;
  top: -17px !important;
  left: 283px !important;
  z-index: 8 !important;
}

#items_menu .mega-dropdown-menu > li > ul {
  padding: 0 !important;
  margin: 0 !important;
}

#items_menu .mega-dropdown-menu > li > ul > li {
  list-style: none !important;
}

#items_menu .mega-dropdown-menu > li > ul > li > a {
  display: block;
  padding: 3px 20px;
  clear: both;
  font-weight: normal;
  line-height: 1.428571429;
  color: #999;
  white-space: normal;
}

#items_menu .mega-dropdown-menu > li ul > li > a:hover,
#items_menu .mega-dropdown-menu > li ul > li > a:focus {
  text-decoration: none;
  color: #444;
  background-color: #f5f5f5;
}

#items_menu .mega-dropdown-menu .dropdown-header {
  color: #428bca;
  font-size: 18px;
  font-weight: bold;
}

#items_menu .mega-dropdown-menu form {
  margin: 3px 20px;
}

#items_menu .mega-dropdown-menu .form-group {
  margin-bottom: 3px;
}  
</style>
<script type="text/javascript">
  jQuery(document).on('click', '.mega-dropdown', function(e) {
    e.stopPropagation()
  })  
</script>
@endsection