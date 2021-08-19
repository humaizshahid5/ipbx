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
              <table id="example" class="table table-bordered compact table-striped" style="width:100%;">
                  <thead>
                  <tr>
                    <th style="display:none;">#</th>
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
                    @php $number_count=0; $t_duration = 0; $t_cost=0; $sec = 0; @endphp
                    @foreach($calls as $call)
                    @php
                    $c_cost = 0;
                     $t_duration = $t_duration+$call->billsec;
                    @endphp
                
                  <tr>
                    <td style="display:none;">@php $number_count=$number_count+1; @endphp</td>
                    <td>{{ date('M j,Y H:i', strtotime('-1 hours', strtotime($call->calldate))) }} </td>
                    <td>{{ $call->source }}</td>
                    <td>{{ $call->destination }}</td>
                    <td>@if($call->calltype == '1') Local @elseif($call->calltype == '2') Incoming @elseif($call->calltype == '3') Outgoing @endif</td>
                    <td>{{ $call->billsec }}</td>
                    <td>
                    @php $c_rate =0;  $p_name = ""; $m_count= 0; $c_count = 0; @endphp
                    @foreach($rates as $rate)
                      @php
                        $m_count= 0;
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
                            $sec = $call->billsec/60;                      
                           }
                         }
                       
                        }
                      @endphp
                    @endforeach
                    @php echo $p_name; @endphp
                    </td>
                    <td>@php echo $c_rate; @endphp</td>
                    <td>@php  
                      $minutes = $call->billsec/60; 
                     echo $c_cost=  number_format(floatval($c_rate*$minutes), 2, '.', '');
                      $t_cost = $t_cost+$c_cost;
                      @endphp</td>
                  </tr>
                    @endforeach                  
                  </tbody>  
                  <tfoot>
                      <tr>
                      <td></td>
                        <td> &nbsp;Total Calls</td>
                        <td>@php echo $number_count; @endphp</td>


                        <td>Total Duration</td>
                        <td>@php echo $t_duration; @endphp</td>
                        <td></td>
                        <td>Totals Cost</td>
                        <td>R$ @php echo number_format(floatval($t_cost), 2, '.', ''); @endphp</td>
                      </tr>
                    </tfoot>             
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

