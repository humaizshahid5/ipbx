
@extends('layouts.app')


@section('content')
@php $c_rate =0;  $p_name = ""; $t_duration = 0; $t_cost=0; @endphp
@foreach($calls_total as $call)

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
                            $t_duration = $call->billsec/60;
                            $t_cost = $t_cost+($t_duration*$rate->rate);
                            $p_name = $rate->name;
                            
                           
                           }
                         
                           
                         }
                      
                        }
                      @endphp
                    @endforeach
                    
@endforeach

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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
   
    <section class="content">
        <div class="container-fluid">
                <div class="card card-default">
                    <div class="card-body">
                        <h2>Welcome, {{ auth()->user()->name }}</h2>
                    </div>
                </div>
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $calls_today }}</h3>

                        <p>Calls Today</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <a href="{{ route('calls') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
        
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                    <div class="inner">
                    <h3>{{ $calls_count }}</h3>

                        <p>Total Calls</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('calls') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
           
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>@php   echo number_format(floatval($t_cost), 3, '.', ''); @endphp </h3>

                        <p>Total Cost</p>
                    </div>
                    <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                    </div>
                    <a href="{{ route('calls') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

        
            <!-- right col -->
            </div>
            <!-- /.row (main row) -->
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Latest Calls</h3>
                 </div>
           
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
                    @php  $t_duration = 0; $t_cost=0; $sec = 0; @endphp
                    @foreach($calls as $call)
                    @php
                    $c_cost = 0;
                     $t_duration = $t_duration+$call->billsec;
                    @endphp
                    <?php $inc =  $loop->iteration ?> 
                  <tr>
                    <td>{{ $inc }}</td>
                    <td>{{ date('M j, Y g:i a', strtotime('-1 hours', strtotime($call->calldate))) }} </td>
                    <td>{{ $call->source }}</td>
                    <td>{{ $call->destination }}</td>
                    <td>@if($call->calltype == '1') Local @elseif($call->calltype == '2') Incoming @elseif($call->calltype == '3') Outgoing @endif</td>
                    <td>{{ $call->billsec }}</td>
                    <td>
                      @php $c_rate =0;  $p_name = ""; @endphp
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Total Duration</td>
                        <td>@php echo $t_duration; @endphp</td>
                        <td></td>
                        <td>Totals</td>
                        <td>@php echo number_format(floatval($t_cost), 2, '.', ''); @endphp</td>

                      </tr>
                    </tfoot>             
                </table>
              </div>
              </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->
  @endsection

