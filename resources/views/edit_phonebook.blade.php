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
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Phone Book</h1>
          </div>
          <div class="col-sm-6">
           
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Add Phone Number</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            @foreach($data as $edit)
                <form action="/edit_number/{{ $edit->id }}/edit" method="post">
                    @csrf
                    <div class="row">
                    <div class="col-lg-6 col-xs-12">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $edit->name }}" required />
                        </div>
                       
                        <div class="col-lg-6 col-xs-12">
                            <label>Number</label>
                            <input type="number" class="form-control" name="number"  value="{{ $edit->number }}" required />
                        </div>
                      
                       
                       
                    
                        <div class="col-lg-12 col-sm-12">
                            <br>
                            <button type="submit" class="btn btn-primary btn-block">Edit Number</button>
                        </div>
                       
                    </div>
                </form>
                @endforeach
            </div>
            <!-- /.row -->
          </div>
         
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  @endsection