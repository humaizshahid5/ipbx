@extends('layouts.app')

@section('content') 

<div class="content-wrapper">
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <br>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Filter</h3>
              </div>
              <div class="card-body">
              <form action="{{ route('search_calls') }}" method="get">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                      <label>
                        From
                      </label>
                      <input type="date" class="form-control @error('fromdate') is-invalid @enderror" name="fromdate"  />
                    </div>
                    <div class="col-md-6">
                      
                      <label>
                        To
                      </label>
                      <input type="date" class="form-control @error('todate') is-invalid @enderror" name="todate" />
                    </div>
                    <div class="col-md-6">
                      <label>
                        Source
                      </label>
                      <input type="number" class="form-control" name="source" />
                    </div>
                    <div class="col-md-6">
                      <label>
                        Destination
                      </label>
                      <input type="text" class="form-control" name="destination" />
                    </div>
                    <div class="col-md-6">
                      <label>
                        Call Type
                      </label>
                      <select class="form-control" name="type">
                                <option value="">Select One</option>
                                <option value="1">Local</option>
                                <option value="2">Incoming</option>
                                <option value="3">Outgoing</option>
                            </select>
                    </div>
                    <div class="col-md-6">
                      <label>
                        Duration
                      </label>
                      <input type="number" class="form-control" name="duration" />
                    </div>
                  <div class="col-lg-12 col-sm-12">
                              <br>
                              <button type="submit" class="btn btn-primary btn-block">Search</button>
                          </div>
                  </div>
              </form>
              </div>
              </div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Calls</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">  
                @include("layouts.table")
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
</div>

@endsection

