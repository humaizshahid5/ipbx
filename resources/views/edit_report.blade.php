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
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Email Reports</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
              @foreach($data as $edit)
                <form action="/edit_report/{{ $edit->id }}/edit" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-xs-12">
                            <label>Email to</label>
                            <input type="email" class="form-control" name="email" value="{{ $edit->email }}" required />
                            @error('email')
                              
                                    <p class="input-error" >{{ $message }}</p>
                               
                            @enderror
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <label>Period</label>
                            <input type="number" class="form-control" name="period" value="{{ $edit->period }}" required />
                            @error('period')
                              
                                    <p class="input-error" >{{ $message }}</p>
                               
                            @enderror
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <label>Data Range</label>
                            <select class="form-control" name="range">
                              <option {{ $edit->range == '1' ? 'selected' : '' }} value="1">Last 15 Days</option>
                              <option {{ $edit->range == '2' ? 'selected' : '' }} value="2">Last 30 Days</option>
                              <option {{ $edit->range == '3' ? 'selected' : '' }} value="3">Last Month</option>

                            </select>
                            @error('range')
                              
                                    <p class="input-error" >{{ $message }}</p>
                               
                            @enderror
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <label>Data Type</label>
                          <select id="choices-multiple-remove-button" name="type[]" multiple >
                            <option  @foreach(unserialize($edit->type) as $type) {{ $type == '1' ? 'selected' : '' }} @endforeach value="1" >Local</option>
                            <option  @foreach(unserialize($edit->type) as $type) {{ $type == '2' ? 'selected' : '' }} @endforeach value="2">Incoming</option>
                            <option  @foreach(unserialize($edit->type) as $type) {{ $type == '3' ? 'selected' : '' }} @endforeach value="3">Outgoing</option>               
                        </select>
                        @error('type')
                              
                                    <p class="input-error" >{{ $message }}</p>
                               
                            @enderror
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <label>Source</label>
                            <input type="number" class="form-control" name="source" value="{{ $edit->source }}"  />
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <label>Destination</label>
                            <input type="number" class="form-control" name="destination" value="{{ $edit->destination }}"  />
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <label>Duration</label>
                            <input type="number" class="form-control" name="duration" value="{{ $edit->duration }}"  />
                        </div>
                        
                     
                    
                        <div class="col-lg-12 col-sm-12">
                            <br>
                            <button type="submit" class="btn btn-primary btn-block">Edit Reporting</button>
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