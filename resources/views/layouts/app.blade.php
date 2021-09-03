<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Abratel Tecnologia</title>

    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->

    <link href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <script src="{{ asset('js/adminlte.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/chart.js') }}"></script>
    
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
 
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
   

    


	<script type="text/javascript" class="init">
	
$(document).ready(function() {
	var table = $('#example').DataTable( {
		lengthChange: true,
    "pageLength": 100,
    buttons: [
      {
                extend: 'pdfHtml5',
                orientation: 'horizental',
                pageSize: 'Letter',
                footer : true,          
                exportOptions: {
                    columns: [ 1,2,3,4,5,6,7,8 ]
                }
            },
            { extend: 'excelHtml5', footer: true },
            { extend: 'csvHtml5', footer: true },
           
            'colvis'

        ]
        
    
	} );
	table.buttons().container()
		.appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
	</script>
 
 
  



  
</head>
<body class="hold-transition sidebar-mini">
  
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('img/loader.gif') }}" alt="AdminLTELogo" height="60" width="60">
  </div>

<div class="wrapper">
    <div id="app">
        
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
     
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
   

      <!-- Messages Dropdown Menu -->
    
      <!-- Notifications Dropdown Menu -->
      @if(session()->get('activation_status') == false)
      <li class="nav-item">
        <a class="nav-link btn btn-md btn-danger"  href="{{ route('activation') }}" role="button" style="color:white;">
        <i class="fas fa-lock"></i> Activation Required 
        </a>
      </li>
      @endif
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
         <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link"  href="{{ route('logout') }}">
        Welcome, {{ auth()->user()->name }}
          <i class="fas fa-lock"></i>
        </a>
      </li>
    </ul>
  </nav>
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="height:auto;">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
      
     <center><span class="brand-text font-weight-light text-center ">Control Panel</span></center>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
     
      <!-- SidebarSearch Form -->
      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ (request()->is('dashboard','/')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
               
              </p>
            </a>
           
          </li>
          @if(session()->get('activation_status') == false)

        
          @else
        
          <li class="nav-item">
            <a href="{{ route('calls') }}" class="nav-link {{ (request()->is('calls')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-phone-alt"></i>
              <p>
                Calls Record
                
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('pricing') }}" class="nav-link {{ (request()->is('pricing')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                Prcing
                
              </p>
            </a>
          </li>
          @if(auth()->user()->role == '1')
          <li class="nav-item">
            <a href="{{ route('users') }}" class="nav-link {{ (request()->is('users')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                User Mangment
              </p>
            </a>
          </li>
          @endif
          <li class="nav-item">
            <a href="{{ route('report') }}" class="nav-link {{ (request()->is('report')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Reporting
                
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Settings
                <i class="fas fa-angle-left right"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('api')}}" class="nav-link">
                  <i class="fas fa-link nav-icon"></i>
                  <p>API</p>
                </a>
              </li>
              @endif
             
             
           
            </ul>
          </li>

       

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>


        <main>
            @yield('content')
            
        </main>
       
        <footer class="main-footer text-center">
    <strong>Developed by HumAiz Shahid &nbsp;(Latest Build 1.4)</strong>

  </footer>
    </div>
</div>





    <script src="{{ asset('js/adminlte.min.js') }}"></script>
    
  


</body>
</html>
