<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Inventory Management System </title>

<!-- Data Table -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
<!-- Data Table -->


    <!-- Bootstrap -->
    <link href="{{ asset('public/theme/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('public/theme/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('public/theme/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="{{ asset('public/theme/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('public/theme/bootstrap-daterangepicker/daterangepicker.css') }}?var=4" rel="stylesheet">    
    <!-- Custom Theme Style -->

    <!-- iCheck -->
    <link href="{{ asset('public/theme/iCheck/skins/flat/green.css') }}" rel="stylesheet">

    <!-- bootstrap-wysiwyg -->
    <link href="{{ asset('public/theme/google-code-prettify/bin/prettify.min.css') }}" rel="stylesheet">

    <!-- Switchery -->
    <link href="{{ asset('public/theme/switchery/dist/switchery.min.css') }}" rel="stylesheet">
    <!-- starrr -->
    <link href="{{ asset('public/theme/starrr/dist/starrr.css') }}" rel="stylesheet">

    <!-- Bootstrap Colorpicker -->
    <link href="{{ asset('public/theme/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <link href="{{ asset('public/theme/build/css/custom.min.css') }}?var=4" rel="stylesheet">
	<script type="text/javascript" src="{{ asset('public/js/cw_utils.js') }}?var=4"></script>    

  </head>

    <body class="nav-sm"> <!-- nav-md -->

    <div class="container body">

      <div class="main_container">
        @if (Auth::check())
              @include('layouts/sidemenu')

              @include('layouts/topbar')
              <div class="right_col" role="main">
                  @if ($errors->any())
                        <div class="alert alert-danger" style="margin-top: 57px;">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session()->has('success'))
                        <div class="alert alert-success" style="margin-top: 57px;">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-danger" style="margin-top: 57px;">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                  @yield('content')
              </div>
         @else
              @yield('content')         
         @endif

      </div>
    </div>


    <!-- jQuery -->
    <script src="{{ asset('public/theme/jquery/dist/jquery.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   
 


    <!-- Bootstrap --> 
    <script src="{{ asset('public/theme/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    
    <!-- NProgress -->
    <script src="{{ asset('public/theme/nprogress/nprogress.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('public/theme/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('public/theme/bootstrap-daterangepicker/daterangepicker.js') }}?var=4"></script>


    <!-- bootstrap-wysiwyg 
    <script src="{{ asset('public/theme/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js') }}"></script>
    <script src="{{ asset('public/theme/jquery.hotkeys/jquery.hotkeys.js') }}"></script>
    <script src="{{ asset('public/theme/google-code-prettify/src/prettify.js') }}"></script>
    -->


    <!-- Bootstrap Colorpicker -->
    <script src="{{ asset('public/theme/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{ asset('public/theme/build/js/custom.min.js') }}?var=4"></script>
    @yield('scripts');


    <div class="modal fade bs-example-modal-lg" id="show_modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

        </div>
      </div>
    </div>

    <script type="text/javascript">
      $('.modal_link').on('click', function(e){
      e.preventDefault();
      $('#show_modal').modal('show').find('.modal-content').load($(this).attr('href'));
    });
        $(document).ready(function() {
        	$('.nav .child_menu').hide();
        });    
    </script>    
        <style type="text/css">
            { display: none; }
        </style>

    </body>
</html>