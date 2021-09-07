
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
                    $free = false;
                    
                     $t_duration = $t_duration+$call->billsec;
                    @endphp
                
                  <tr>
                    <td style="display:none;">@php $number_count=$number_count+1; @endphp</td>
                    <td>{{ date('M j,Y H:i', strtotime('-1 hours', strtotime($call->calldate))) }} </td>
                   
                    <td>
                      
                      @if($call->source == $call->s_number)
                      <a href="#" data-toggle="tooltip{{ $call->cdr_id }}" title="{{ $call->source }}">
                      {{ $call->s_name }}
                      </a>
                      @else
                      {{ $call->source }}

                      @endif
                    </td>
                    <td>
                      @if($call->destination == $call->d_number)
                      <a href="#" data-toggle="tooltip{{ $call->cdr_id }}" title="{{ $call->destination }}">
                       {{ $call->d_name }}
                      </a>
                      @else
                      {{ $call->destination }}

                      @endif
                    </td>
                    <script>
                    $(document).ready(function(){
                      $('[data-toggle="tooltip{{ $call->cdr_id }}"]').tooltip();   
                    });
                    $(document).ready(function(){
                      $('[data-toggle="tooltip2{{ $call->cdr_id }}"]').tooltip();   
                    });
                    </script>
                    <td>@if($call->calltype == '1') Local @elseif($call->calltype == '2') Incoming @elseif($call->calltype == '3') Outgoing @endif</td>
                    <td>{{ $call->billsec }}</td>
                    <td>
                      @php $c_rate =0;  $p_name = ""; $c_count =0; @endphp
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
                                if($call->billsec <=	$rate->grace)
                                {
                                  $c_rate = $rate->rate;
                                  $p_name = $rate->name;
                                  $free = true;
                                }
                              else{
                                if($rate->rate == 0){
                                  $c_cost = 0;
                                  $p_name = $rate->name;
                                }
                                else{
                                  $c_count = $m_count;
                                  $c_rate = $rate->rate;
                                  $p_name = $rate->name;
                                 
                                  $c_cost =round ( $rate->rate / 60 * ( $call->billsec <= $rate->minimal ? $rate->minimal : ceil ( $call->billsec / $rate->fraction) * $rate->fraction), 2);
                                  $t_cost = $t_cost+$c_cost;
                                }
                              }
                              
                            }
                            }
                          }
                          @endphp
                      @endforeach
                    @php
                    if($p_name == "" ){
                      if($call->calltype == '1'){
                           echo "Recebida";
                      }
                      elseif($call->calltype == '3'){
                             echo "Sem Tarifa";
                        }
                    } 
                    else{
                      echo $p_name;
                    }
                    
                   @endphp
                    </td>
                    <td>@php echo $c_rate; @endphp</td>
                    <td>@php  
                      if($free == true){
                        echo "Free";
                      }
                      else{
                         echo number_format(floatval($c_cost), 2, ',', '');
                      }
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
                        <td>@php echo number_format(floatval($t_cost), 2, ',', ''); @endphp</td>
                      </tr>
                    </tfoot>             
                </table>


             