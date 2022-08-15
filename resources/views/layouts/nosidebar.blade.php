<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Amazon EBay Fashionwholesaler </title>

    <!-- Bootstrap -->
    <link href="{{ asset('theme/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('theme/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('theme/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="{{ asset('theme//bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('theme//bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">    
    <!-- Custom Theme Style -->

    <!-- iCheck -->
    <link href="{{ asset('theme/iCheck/skins/flat/green.css') }}" rel="stylesheet">
    <!-- Datatables -->
    <link href="{{ asset('theme/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">

    <!-- bootstrap-wysiwyg -->
    <link href="{{ asset('theme/google-code-prettify/bin/prettify.min.css') }}" rel="stylesheet">
    <!-- Select2 -->
    <link href="{{ asset('theme/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <!-- Switchery -->
    <link href="{{ asset('theme/switchery/dist/switchery.min.css') }}" rel="stylesheet">
    <!-- starrr -->
    <link href="{{ asset('theme/starrr/dist/starrr.css') }}" rel="stylesheet">

    <link href="{{ asset('theme/build/css/custom.min.css') }}" rel="stylesheet">    

  </head>

    <body class="nav-md">

    <div class="container body">
      <div class="main_container">
        @if (Auth::check())
              @include('layouts/topbar')
              <div class="right_col" role="main">
                  @yield('content')
              </div>
         @else
              @yield('content')         
         @endif

      </div>
    </div>


    <!-- jQuery -->
    <script src="{{ asset('theme/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('theme/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('theme/fastclick/lib/fastclick.js') }}"></script>

    <!-- NProgress -->
    <script src="{{ asset('theme/nprogress/nprogress.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('theme/iCheck/icheck.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('theme/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theme/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('theme/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('theme/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('theme/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('theme/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('theme/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('theme/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('theme/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
    <script src="{{ asset('theme/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
    <script src="{{ asset('theme/jszip/dist/jszip.min.js') }}"></script>
    <script src="{{ asset('theme/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('theme/pdfmake/build/vfs_fonts.js') }}"></script>

    <!-- bootstrap-wysiwyg -->
    <script src="{{ asset('theme/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js') }}"></script>
    <script src="{{ asset('theme//jquery.hotkeys/jquery.hotkeys.js') }}"></script>
    <script src="{{ asset('theme//google-code-prettify/src/prettify.js') }}"></script>


    <!-- Custom Theme Scripts -->
    <script src="{{ asset('theme/build/js/custom.min.js') }}"></script>

    </body>
</html>