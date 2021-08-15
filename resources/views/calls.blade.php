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
                <table id="example" class="table table-bordered table-striped" style="width:100%;">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Source</th>
                    <th>Destination</th>
                    <th>Type</th>
                    <th>Duration</th>
                    <th>Price Name</th>
                    <th>Rate</th>
                    <th>Cost</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($calls as $call)
                    <?php $inc =  $loop->iteration ?> 
                  <tr>
                    <td>{{ $inc }}</td>
                    <td>{{ date('M j, Y g:i a',strtotime($call->calldate)) }}</td>
                    <td>{{ $call->source }}</td>
                    <td>{{ $call->destination }}</td>
                    <td>@if($call->calltype == '1') Local @elseif($call->calltype == '2') Incoming @elseif($call->calltype == '3') Outgoing @endif</td>
                    <td>{{ $call->duration }}</td>
                    <td>
                      @php $c_rate =0;  $p_name = ""; $t_duration = 0; $t_cost=0; @endphp
                    @foreach($rates as $rate)
                      @php
                        $c_count =0;
                        $price_data = $rate->destination;
                        $call_data = $call->destination;
                        $p_values = array();
                        $c_values = array();
                        $p_num = array();
                        $status = 0;
                        if(preg_match("/[a-z]/i", $call_data)){
                           break;
                        }
                        if(strlen($price_data) == strlen($call_data) && $call->calltype == $rate->type){
                        for($i = 0, $length = strlen($price_data); $i < $length; $i++) {
                            if(is_numeric($price_data[$i])){
                                     $p_values[] =$i." | ".$price_data[$i]."<br>";
                                    $p_num[] = $i;
                            }
                          }
                          for($i = 0, $length = strlen($call_data); $i < $length; $i++) {
                              $c_values[] = $i." | ".$call_data[$i]. "<br>";
                          }
                          $num = count($p_num);
                          $m_count= 0;
                          for($i = 0; $i < $num; $i++){
                          $p_val = $p_num[$i];
                          if($p_values[$i] == $c_values[$p_val]){
                             $m_count = $m_count+1;
                          $status = 1;
                          }
                          else{
                           $status = 0;
                           break;
                          }
                          }
                         if($status == 1){
                           if($m_count > $c_count)
                           {
                            $c_count = $m_count;
                            $c_rate = $rate->rate;
                            $p_name = $rate->name;
                           }
                         }
                        }
                      @endphp
                    @endforeach
                    @php echo $p_name; @endphp
                    </td>
                    <td>@php echo $c_rate; @endphp</td>
                    <td>@php  $minutes = $call->duration/60; echo number_format(floatval($c_rate*$minutes), 2, '.', ''); @endphp</td>
                  </tr>
                    @endforeach                   
                  </tbody>                
                </table>
              </div>
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
