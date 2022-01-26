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
      </div>
      <!-- /.container-fluid -->
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <!-- SELECT2 EXAMPLE -->
         @isset($data)
         <div class="card card-default">
         <div class="card-header">
               <div class="row">
                  <div class="col-6 my-auto">
                     <h3 class="card-title">Edit Pricing</h3>
                  </div>
                  <div class="col-6 my-auto">
                     <div class="float-right">
                        <a href="{{ route('pricing') }}"<button class="btn btn-primary btn-md"><i class="fas fa-plus"></i> Add New Pricing</button></a>
                     </div>
                  </div>
               </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
               @foreach($data as $edit)
               <form action="/edit_price/{{ $edit->id }}/edit" method="post">
                  @csrf
                  <div class="row">
                     <div class="col-lg-12 col-xs-12">
                     @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $edit->name }}" required />
                     </div>
                     <div class="col-lg-6 col-xs-12">
                     @error('sdn')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        <label>Source/Destination</label>
                        <input type="text" class="form-control" value="{{ $edit->sdn }}" name="sdn" required />
                     </div>
                     <div class="col-lg-6 col-xs-12">
                     @error('rate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        <label>Rate</label>
                        <input type="number" class="form-control" value="{{ $edit->rate }}" name="rate" step="0.01" required />
                     </div>

                     <div class="col-lg-6 col-xs-12" >
                     @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        <label>Type</label>
                        <select class="form-control" name="type" required>
                        <option {{ $edit->type == '1' ? 'selected' : '' }} value="1">Local</option>
                        <option {{ $edit->type == '2' ? 'selected' : '' }} value="2">Incoming</option>
                        <option {{ $edit->type == '3' ? 'selected' : '' }} value="3">Outgoing</option>
                        </select>
                     </div>
                     <div class="col-lg-6 col-xs-12">
                     @error('grace')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        <label>Grace Time</label>
                        <input type="number" class="form-control" value="{{ $edit->grace }}" name="grace" step="0.01" required />
                     </div>
                     <div class="col-lg-6 col-xs-12">
                     @error('minimal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        <label>Minimal Seconds</label>
                        <input type="number" class="form-control" value="{{ $edit->minimal }}" name="minimal" step="0.01" required />
                     </div>
                     <div class="col-lg-6 col-xs-12">
                     @error('fraction')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        <label>Time Fraction</label>
                        <input type="number" class="form-control" value="{{ $edit->fraction }}" name="fraction" step="0.01" required />
                     </div>
                     <div class="col-lg-12 col-sm-12">
                        <br>
                        <button type="submit" class="btn btn-info btn-block">Edit Price</button>
                     </div>
                  </div>
               </form>
               @endforeach
            </div>
            <!-- /.row -->
         </div>
         @else
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
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required />
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                     <div class="col-lg-6 col-xs-12">
                     
                        <label>Source/Destination</label>
                        <input type="text" class="form-control @error('sdn') is-invalid @enderror" name="sdn" value="{{ old('sdn') }}" required />
                        @error('sdn')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                     <div class="col-lg-6 col-xs-12">
                    
                        <label>Rate</label>
                        <input type="number" class="form-control @error('rate') is-invalid @enderror" name="rate" value="{{ old('rate') }}" step="0.01" required />
                        @error('rate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                     </div>
                     <div class="col-lg-6 col-xs-12" >
                    
                        <label>Type</label>
                        <select class="form-control @error('type') is-invalid @enderror" name="type" required>
                           <option value="">Select One</option>
                           <option value="1">Local</option>
                           <option value="2">Incoming</option>
                           <option value="3">Outgoing</option>
                        </select>
                        @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                         @enderror
                     </div>
                     <div class="col-lg-6 col-xs-12">
                    
                        <label>Grace Time</label>
                        <input type="number" class="form-control @error('grace') is-invalid @enderror" value="{{ old('grace') }}" name="grace" step="0.01" required />
                        @error('grace')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                     </div>
                     <div class="col-lg-6 col-xs-12">
                    
                        <label>Minimal Seconds</label>
                        <input type="number" class="form-control @error('minimal') is-invalid @enderror" name="minimal" value="{{ old('minimal') }}" step="0.01" required />
                        @error('minimal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                     </div>
                     <div class="col-lg-6 col-xs-12">
                   
                        <label>Time Fraction</label>
                        <input type="number" class="form-control" name="fraction @error('fraction') is-invalid @enderror" value="{{ old('fraction') }}" step="0.01" required />
                        @error('fraction')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
         @endif
         <!-- /.card-body -->
         <div class="card card-default">
            <div class="card-header">
               <h3 class="card-title">Pricing</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
               <div class="table-responsive" >
                  <table id="usertable" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Name</th>
                           <th>Src/Dst</th>
                           <th>Rate</th>
                           <th>Type</th>
                           <th>Grace</th>
                           <th>Minimal</th>
                           <th>Fraction</th>
                           <th>Edit</th>
                           <th>Delete</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if($pricing->count())
                        @foreach($pricing as $price)
                        <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>{{ $price->name }}</td>
                           <td>{{ $price->sdn }}</td>
                           <td>{{ number_format(floatval($price->rate), 2, ',', ''); }}</td>
                           <td>@if($price->type == '1') Local @elseif($price->type == '2') Incoming @elseif($price->type == '3') Outgoing @endif </td>
                           <td>{{ $price->grace }}</td>
                           <td>{{ $price->minimal }}</td>
                           <td>{{ $price->fraction }}</td>
                           <td><a href="/pricing/{{$price->id}}/edit"><button class="btn btn-info btn-block"><i class="fas fa-edit"></i></button></a></td>
                           <td><a href="/del_price/{{$price->id}}/del"><button class="btn btn-danger btn-block"><i class="fas fa-trash"></i></button></a></td>
                        </tr>
                        @endforeach
                        @endif
                     </tbody>
                  </table>
               </div>
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