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
<div class="card card-default">
   <div class="card-header">
      <h3 class="card-title">Add Pricing</h3>
   </div>
   <!-- /.card-header -->
   <div class="card-body">
      @foreach($data as $edit)
      <form action="/edit_price/{{ $edit->id }}/edit" method="post">
         @csrf
         <div class="row">
            <div class="col-lg-12 col-xs-12">
               <label>Name</label>
               <input type="text" class="form-control" name="name" value="{{ $edit->name }}" required />
            </div>
            <div class="col-lg-6 col-xs-12">
               <label>Source/Destination</label>
               <input type="text" class="form-control" value="{{ $edit->sdn }}" name="sdn" required />
            </div>
            <div class="col-lg-6 col-xs-12">
               <label>Rate</label>
               <input type="number" class="form-control" value="{{ $edit->rate }}" name="rate" step="0.01" required />
            </div>
            <div class="col-lg-6 col-xs-12" >
               <label>Type</label>
               <select class="form-control" name="type" required>
               <option {{ $edit->type == '1' ? 'selected' : '' }} value="1">Local</option>
               <option {{ $edit->type == '2' ? 'selected' : '' }} value="2">Incoming</option>
               <option {{ $edit->type == '3' ? 'selected' : '' }} value="3">Outgoing</option>
               </select>
            </div>
            <div class="col-lg-6 col-xs-12">
               <label>Grace Time</label>
               <input type="number" class="form-control" value="{{ $edit->grace }}" name="grace" step="0.01" required />
            </div>
            <div class="col-lg-6 col-xs-12">
               <label>Minimal Seconds</label>
               <input type="number" class="form-control" value="{{ $edit->minimal }}" name="minimal" step="0.01" required />
            </div>
            <div class="col-lg-6 col-xs-12">
               <label>Time Fraction</label>
               <input type="number" class="form-control" value="{{ $edit->fraction }}" name="fraction" step="0.01" required />
            </div>
            <div class="col-lg-12 col-sm-12">
               <br>
               <button type="submit" class="btn btn-primary btn-block">Edit Price</button>
            </div>
         </div>
      </form>
      @endforeach
   </div>
   <!-- /.row -->
</div>
@endsection