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
               <h1>User Mangment</h1>
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
        @isset($data)
        <div class="card card-default">
            <div class="card-header">
               <h3 class="card-title">Add New Users</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
               @foreach($data as $edit)
               <form action="/user_edit/{{ $edit->id }}/edit" method="POST">
                  @csrf
                  <div class="row">
                     <div class="col-lg-6 col-xs-12">
                        <label>Name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $edit->name }}" required autocomplete="name" autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                     <div class="col-lg-6 col-xs-12">
                        <label>Username</label>
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $edit->username }}" required autocomplete="email">
                        @error('username')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                     <div class="col-lg-6 col-xs-12">
                        <label>Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  >
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                     <div class="col-lg-6 col-xs-12">
                        <label>Role</label>
                        <select class="form-control" name="role" required>
                        <option  {{ $edit->role == '2' ? 'selected' : '' }}  value="0">User</option>
                        <option  {{ $edit->role == '1' ? 'selected' : '' }}  value="1">Administrator</option>
                        </select>
                     </div>
                     <div class="col-lg-12 col-sm-12">
                        <br>
                        <button type="submit" class="btn btn-primary btn-block">Edit User</button>
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
               <h3 class="card-title">Add New Users</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
               <form action="{{ route('create_user') }}" method="POST">
                  @csrf
                  <div class="row">
                     <div class="col-lg-6 col-xs-12">
                        <label>Name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                     <div class="col-lg-6 col-xs-12">
                        <label>Username</label>
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="email">
                        @error('username')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                     <div class="col-lg-6 col-xs-12">
                        <label>Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required >
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                     <div class="col-lg-6 col-xs-12">
                        <label>Role</label>
                        <select class="form-control" name="role" required>
                           <option value="0">User</option>
                           <option value="1">Administrator</option>
                        </select>
                     </div>
                     <div class="col-lg-12 col-sm-12">
                        <br>
                        <button type="submit" class="btn btn-primary btn-block">Add User</button>
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
               <h3 class="card-title">Users</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
               <div class="table-responsive" >
                  <table id="usertable" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Name</th>
                           <th>Username</th>
                           <th>Role</th>
                           <th>Edit</th>
                           <th>Delete</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if($users->count())
                        @foreach($users as $user)
                        <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>{{ $user->name }}</td>
                           <td>{{ $user->username }}</td>
                           <td>@if($user->role  == 1) Administrator @else User @endif</td>
                           <td><a href="/users/{{$user->id}}/edit " title="Edit signature"><button class="btn btn-info btn-block" ><i class="fas fa-edit"></i></button></a></td>
                           <td><a href="/del_user/{{$user->id}}/del " title="Edit signature"><button class="btn btn-danger btn-block" @if(auth()->user()->id == $user->id) disabled @endif><i class="fas fa-trash"></i></button></a></td>
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