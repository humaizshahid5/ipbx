@extends('layouts.app')

@section('content')

<script type="text/javascript" class="init">
	


    $(document).ready(function() {
        var table = $('#usertable').DataTable( {
            lengthChange: true,
            "pageLength": 100
           
        } );
    
        table.buttons().container()
            .appendTo( '#example_wrapper .col-md-6:eq(0)' );
    } );
    
    
    
        </script>
        <style>
          
        </style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Reporting</h1>
          </div>
          
        </div>
       

       
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->


        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
 
  @endsection