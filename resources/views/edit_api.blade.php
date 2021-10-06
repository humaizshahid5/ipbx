
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
            <h1>API Mangment</h1>
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
            <h3 class="card-title">Add New API</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
              @foreach($data as $edit)
                <form action="/edit_api/{{ $edit->id }}/edit" method="POST">
                        @csrf
                    <div class="row">
                        <div class="col-lg-6 col-xs-12">
                            <label>URL</label>
                            <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ $edit->url }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <label>KEY</label>
                            <input id="key" type="text" class="form-control @error('key') is-invalid @enderror" name="key" value="{{ $edit->key }}" required autocomplete="email">
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                       
                       
                    
                        <div class="col-lg-12 col-sm-12">
                            <br>
                            <button type="submit" class="btn btn-primary btn-block">Edit API</button>
                        </div>
                    </div>
                </form>
                @endforeach
            </div>
            <!-- /.row -->
          </div>
    

        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  @endsection