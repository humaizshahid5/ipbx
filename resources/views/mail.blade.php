@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            
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
              <div class="row">
                  <div class="col-6 my-auto">
                  <h3 class="card-title">Mail Configuration</h3>
                    </div>
                    <div class="col-6 my-auto">
                        <div class="float-right">
                           <button class="btn btn-danger btn-md" data-toggle="modal" data-target="#exampleModal"">Test Mail</button>
                        </div>
                        
                    </div>
                </div>


        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('test_mail') }}" method="POST">
                @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Test Email</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        
                                    <div class="col-12">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="email" required />                                      
                                    </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Send Email</button>    
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
          <!-- /.card-header -->
          <div class="card-body">
              
              @foreach($data as $setting)
              <form action="{{ route('mail_update') }}" method="POST" style="width:auto">
                        @csrf
                    <div class="row">
                   
                        <div class="col-lg-6 col-xs-6">
                            <label>Mail Username</label>
                            <input id="code" type="email" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $setting->username }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                        </div>
                        <div class="col-lg-6 col-xs-6">
                            <label>Mail Password</label>
                            <input id="code" type="text" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ $setting->password }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                        </div>
                        <div class="col-lg-6 col-xs-6">
                            <label>Mail Driver</label>
                            <input id="code" type="text" class="form-control @error('driver') is-invalid @enderror" name="driver" value="{{ $setting->driver }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                        </div>
                        <div class="col-lg-6 col-xs-6">
                            <label>Mail Host</label>
                            <input id="code" type="text" class="form-control @error('host') is-invalid @enderror" name="host" value="{{ $setting->host }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                        </div>
                       
                        <div class="col-lg-6 col-xs-6">
                            <label>Mail Encryption</label>
                            <input id="code" type="text" class="form-control @error('encryption') is-invalid @enderror" name="encryption" value="{{ $setting->encryption }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                        </div>
                        <div class="col-lg-6 col-xs-6">
                            <label>Mail Port</label>
                            <input id="code" type="text" class="form-control @error('from') is-invalid @enderror" name="port" value="{{ $setting->port }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                        </div>
                        <div class="col-lg-6 col-xs-6">
                            <label>Mail From Name</label>
                            <input id="code" type="text" class="form-control @error('from') is-invalid @enderror" name="mail_from" value="{{ $setting->mail_from }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                        </div>
                        <div class="col-lg-6 col-xs-6">
                            <label>Mail From Subject</label>
                            <input id="code" type="text" class="form-control @error('from') is-invalid @enderror" name="mail_subject" value="{{ $setting->mail_subject }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                        </div>
                        <div class="col-12">
                            <label>Mail From Address</label>
                            <input id="code" type="text" class="form-control @error('from') is-invalid @enderror" name="mail_from_address" value="{{ $setting->mail_from_address }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                        </div>
                       
                       
                    
                        <div class="col-12">
                            <br>
                            <button type="submit" class="btn btn-primary btn-block">Update Mail Client</button>
                        </div>
                    </div>
                         
                </form>
                       
                
                @endforeach
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
          
       
     

        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  @endsection