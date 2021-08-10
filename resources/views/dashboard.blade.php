
@extends('layouts.app')


@section('content')
<script type="text/javascript" class="init">
	


    $(document).ready(function() {
        var table = $('#usertable').DataTable( {
            lengthChange: false,
            "pageLength": 70
           
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
                        <h3>{{ $users_count }}</h3>

                        <p>User</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ route('users') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                <table id="usertable" class="table table-bordered table-striped" style="width:100%;">
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
                    <td>{{ $call->calldate }}</td>
                    <td>{{ $call->source }}</td>
                    <td>{{ $call->destination }}</td>
                    <td>@if($call->calltype == '1') Local @elseif($call->calltype == '2') Incoming @elseif($call->calltype == '3') Outgoing @endif</td>
                    <td>{{ $call->duration }}</td>
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
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->
  @endsection

