<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Inventory Management System </title>

    <!-- Bootstrap -->
    <link href="{{ asset('public/theme/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('public/theme/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <!-- iCheck -->
    <link href="{{ asset('public/theme/iCheck/skins/flat/green.css') }}" rel="stylesheet">

    <link href="{{ asset('public/theme/build/css/custom.min.css') }}" rel="stylesheet">    

    <!-- jQuery -->
    <script src="{{ asset('public/theme/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('public/theme/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/theme/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('public/theme/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{ asset('public/theme/build/js/custom.min.js') }}"></script>

  </head>

    <body style="background-color: #fff;"> <!-- nav-md -->

    <div class="container">
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
            <a href="{{ url('/') }}" style="margin: 10px auto; float: none;">Home</a>
              @yield('content')         
    </div>
    
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
    </script>        

    <style>
        body{
            color: #000;
        }
.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th{
    padding-top: 2px !important;
    padding-bottom: 2px !important;
}        
.payment_terms{
    border: 2px solid #000;
    padding: 5px;
    font-size: 11px;
}
.h1, .h2, .h3, h1, h2, h3{
    margin-top: 5px !important;
    margin-bottom: 5px !important;
}
.table{
    margin-bottom:5px !important; 
}
    </style>
    </body>
</html>