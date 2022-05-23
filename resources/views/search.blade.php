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
                      <input type="date" class="form-control @error('fromdate') is-invalid @enderror" name="fromdate"  value="{{ app('request')->input('fromdate') }}" required />
                      @error('fromdate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                      
                      <label>
                        To
                      </label>
                      <input type="date" class="form-control @error('todate') is-invalid @enderror" name="todate" value="{{ app('request')->input('todate') }}" required />
                      @error('todate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                      <label>
                        Source
                      </label>
                      <input type="number" class="form-control" name="source" value="{{ app('request')->input('source') }}" />
                    </div>
                    <div class="col-md-6">
                      <label>
                        Destination
                      </label>
                      <input type="text" class="form-control" name="destination" value="{{ app('request')->input('destination') }}" />
                    </div>
                    <div class="col-md-6">
                      <label>
                        Call Type
                      </label>
                     
                      <select   id="choices-multiple-remove-button" name="type[]" multiple  >
                              @if(app('request')->input("type"))
                             
                                  <option  @foreach(app('request')->input("type") as $type1) {{ $type1 == '1' ? 'selected' : '' }} @endforeach  value="1">Local</option>
                                  <option  @foreach(app('request')->input("type") as $type2) {{ $type2 == '2' ? 'selected' : '' }} @endforeach value="2">Incoming</option>
                                  <option  @foreach(app('request')->input("type") as $type3) {{ $type3 == '3' ? 'selected' : '' }} @endforeach  value="3">Outgoing</option>
                                  @else
                                  <option value="1">Local</option>
                                  <option value="2">Incoming</option>
                                  <option value="3">Outgoing</option>

                                  @endif
                        </select>

                             
                             


                              
                           
                    </div>
                    <div class="col-md-6">
                      <label>
                        Duration
                      </label>
                      <input type="number" class="form-control" name="duration" value="{{ app('request')->input('duration') }}" />
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

