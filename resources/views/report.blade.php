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
                <form action="{{ route('add_report') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 col-xs-12">
                            <label>Email to</label>
                            <input type="email" class="form-control" name="email" required />
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <label>Period</label>
                            <input type="number" class="form-control" name="period" required />
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <label>Data Range</label>
                            <select class="form-control" name="range">
                              <option value="1">Last 15 Days</option>
                              <option value="2">Last 30 Days</option>
                              <option value="3">Last Month</option>

                            </select>
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <label>Data Type</label>
                            <select class="form-control" name="type">
                                <option value="1">Local</option>
                                <option value="2">Incoming</option>
                                <option value="3">Outgoing</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <label>Source</label>
                            <input type="number" class="form-control" name="source"  />
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <label>Destination</label>
                            <input type="number" class="form-control" name="destination"  />
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <label>Duration</label>
                            <input type="number" class="form-control" name="duration"  />
                        </div>
                        
                     
                    
                        <div class="col-lg-12 col-sm-12">
                            <br>
                            <button type="submit" class="btn btn-primary btn-block">Add Reporting</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
          <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Users</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
          <table id="usertable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Email</th>
                    <th>Period</th>
                    <th>Range</th>
                    <th>Data Type</th>
                    <th>Source</th>
                    <th>Destination</th>
                    <th>Duration</th>
                    <th>Send Now</th>
                    <th>Delete</th>
                  </tr>
                  </thead>
                  <tbody>
                      @if($reports->count())
                      @foreach($reports as $report )
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $report->email }}</td>
                    <td>{{ $report->period }}</td> 
                    <td>@if($report->type == '1') Local @elseif($report->type == '2') Incoming @elseif($report->type == '3') Outgoing @endif</td>
                    <td>@if($report->range == '1') 15 Days @elseif($report->range == '2') Last 30 Days @elseif($report->range == '3') Last Month @endif</td>
                    <td>{{ $report->source }}</td> 
                    <td>{{ $report->destination }}</td> 
                    <td>{{ $report->duration }}</td> 
                    <td><a href="/sendnow/{{$report->id}}/send"><button class="btn btn-info btn-block"><i class="fas fa-envelope"></i></button></a></td>
                    <td><a href="/del_report/{{$report->id}}/del"><button class="btn btn-danger btn-block"><i class="fas fa-trash"></i></button></a></td>

                  </tr>
                  @endforeach
                  @endif


                  </tbody>
                  
                </table>
          </div>
        </div>
       
        </div>
        <!-- /.card -->
       
     

        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  @endsection