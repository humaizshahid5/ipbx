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
            <h1>Pricing</h1>
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
            <h3 class="card-title">Add Pricing</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
                <form action="{{ route('add_pricing') }}" method="post">
                    @csrf
                    <div class="row">
                    <div class="col-lg-12 col-xs-12">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" />
                        </div>
                       
                        <div class="col-lg-6 col-xs-12">
                            <label>Destination</label>
                            <input type="text" class="form-control" name="destination" />
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <label>Rate</label>
                            <input type="number" class="form-control" name="rate" step="0.01" />
                        </div>
                        <div class="col-lg-6 col-xs-12" style="display:none;">
                            <label>Type</label>
                            <select class="form-control" name="type">
                              
                                <option value="3">Outgoing</option>
                            </select>
                        </div>
                    
                        <div class="col-lg-12 col-sm-12">
                            <br>
                            <button type="submit" class="btn btn-primary btn-block">Add Price</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
          <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Pricing</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
          <table id="usertable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Destination</th>
                    <th>Rate</th>
                    <th>Type</th>
                    <th>Delete</th>
                  </tr>
                  </thead>
                  <tbody>
                  @if($pricing->count())
                        @foreach($pricing as $price)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $price->name }}</td>
                    <td>{{ $price->destination }}</td>
                    <td>{{ $price->rate }}</td>
                    <td>@if($price->type == '1') Local @elseif($price->type == '2') Incoming @elseif($price->type == '3') Outgoing @endif </td>
                    <td><a href="/del_price/{{$price->id}}/del"><button class="btn btn-danger btn-block"><i class="fas fa-trash"></i></button></a></td>

                    

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