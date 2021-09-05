
@extends('layouts.app')


@section('content')
@php $c_rate =0;  $p_name = ""; $t_duration = 0; $t_cost=0; @endphp
@foreach($calls_total as $call)

                    @foreach($rates as $rate)
                      @php
                      if($rate->type == '2'){
                            $price_data = $rate->sdn;
                            $call_data = $call->source;
                          }
                          else{
                            $price_data = $rate->sdn;
                            $call_data = $call->destination;
                            
                          }
                        $c_count =0;
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
                        <h3>@php echo date("h:i:s A"); @endphp</h3>

                        <p>Current Time</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clock"></i>
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
                        <h3>R$@php   echo str_replace('.', ',', number_format(floatval($t_cost), 2, '.', '')); @endphp </h3>

                        <p>Total Cost</p>
                    </div>
                    <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                    </div>
                    <a href="{{ route('calls') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-6">
                    
                 
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Daily Calls </h3>
                 </div>
                <div class="card-body">
                <canvas id="myChart"></canvas>
                        <script>
                        var ctx = document.getElementById("myChart").getContext('2d');
                        var myChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ["Outgoing Calls", "Incoming Calls", "Local"],
                            datasets: [{
                            backgroundColor: [
                                "#2ecc71",
                                "#3498db",
                                "#95a5a6"
                                
                            ],
                            data: [{{ $outgoing_count }}, {{ $incoming_count }}, {{ $local_count }}]
                            }]
                        }
                        });
                        </script>
                </div>
            </div>
                   
                </div>
        
                <div class="col-lg-6 col-6">
                     
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Last 30 Days Calls </h3>
                 </div>
                <div class="card-body">
                <canvas id="myChart1"></canvas>
                        <script>
                        var ctx = document.getElementById("myChart1").getContext('2d');
                        var myChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ["Outgoing Calls", "Incoming Calls", "Local"],
                            datasets: [{
                            backgroundColor: [
                                "#2ecc71",
                                "#3498db",
                                "#95a5a6"
                                
                            ],
                            data: [{{ $m_outgoing_count }}, {{ $m_incoming_count }}, {{ $m_local_count }}]
                            }]
                        }
                        });
                        </script>
                </div>
            </div>
                   
                </div>
           
               
            </div>
         
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Latest Calls </h3>
                 </div>
                <div class="card-body">
                  @include("layouts.table")
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->
  @endsection

