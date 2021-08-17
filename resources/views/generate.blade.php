<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '') }}</title>

    <!-- Scripts -->
  

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->

    <link href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <script src="{{ asset('js/adminlte.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
 
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>


	<script type="text/javascript" class="init">
	


$(document).ready(function() {
	var table = $('#example').DataTable( {
		lengthChange: false,
    buttons: [
      {
                extend: 'pdfHtml5',
                orientation: 'horizental',
                pageSize: 'A4',
                footer : true
            },
            { extend: 'excelHtml5', footer: true },
            { extend: 'csvHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true },
            'colvis'

        ]
    
	} );

	table.buttons().container()
		.appendTo( '#example_wrapper .col-md-6:eq(0)' );
    
} );
	</script>
</head>

<script type="text/javascript">
$(function(){
    $('.buttons-pdf').trigger('click');
    document.getElementsByTagName ('html') [0] .remove ();

});
</script>
<input id="close_window" type="button" class="btn btn-success"
                   style="font-weight: bold;display: inline;"
                   value="Close">
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <br>
           


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
