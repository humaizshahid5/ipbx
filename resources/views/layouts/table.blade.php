<div class="table-responsive" >
                   

@php
class MyXYZ{
                        
                        public $c_count,$c_rate,$p_name,$c_cost,$t_cost;
                       

    }
  function add_some_extra($price_data,$call_data,&$call,&$rate)
  {

      
    
      $out = new MyXYZ();
      $p_values = array();
      $c_values = array();
      $p_num = array();
      $status = 0;
     
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
        for($i = 0; $i < $num; $i++)
        {
          $p_val = $p_num[$i];
          if($p_values[$i] == $c_values[$p_val])
          {
            $m_count = $m_count+1;
            $status = 1;
          }
          else
          {
            $status = 0;
          }
        }
      if($status == 1)
      {
        if($m_count > $out->c_count)
        {
          if($call->billsec <=	$rate->grace)
          {
            $out->c_rate = $rate->rate;
            $out->p_name = $rate->name;
            $out->free = true;
          }
          else
          {
            if($rate->rate == 0)
            {
              $out->c_cost = 0;
              $out->p_name = $rate->name;
            }
            else
            {
              $c_count = $m_count;
              $c_rate = $rate->rate;
              $out->p_name = $rate->name;
              $out->c_cost =round ( $rate->rate / 60 * ( $call->billsec <= $rate->minimal ? $rate->minimal : ceil ( $call->billsec / $rate->fraction) * $rate->fraction), 2);
              $out->t_cost = $out->t_cost+$out->c_cost;
            }
          }
        }
      }
     return $out;
     
  }

@endphp
<table id="datatable" class="table table-bordered compact table-striped " >
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
                    @if($call->destination != "" || $call->source != "")
                    @php
                    
                       
                        
                    $xyz = new MyXYZ();
                         
                       
                    
                    $free = false;
                    
                     $t_duration = $t_duration+$call->billsec;
                    @endphp
                
                  <tr>
                    <td style="display:none;">@php $number_count=$number_count+1; @endphp</td>
                    <td>{{ date('M j,Y H:i', strtotime('-1 hours', strtotime($call->calldate))) }} </td>
                   
                    <td>
                      
                      @if($call->source == $call->s_number)
                      <a href="#{{ $call->cdr_id }}" data-toggle="tooltip_source{{ $call->cdr_id }}" title="{{ $call->source }}">
                      {{ $call->s_name }}
                      </a>
                      @else
                      {{ $call->source }}

                      @endif
                    </td>
                    <td>
                      @if($call->destination == $call->d_number)
                      <a href="#{{ $call->cdr_id }}" data-toggle="tooltip_destination{{ $call->cdr_id }}" title="{{ $call->destination }}">
                       {{ $call->d_name }}
                      </a>
                      @else
                      {{ $call->destination }}

                      @endif
                    </td>
                    <script>
                   $('#example').on('mouseover', 'tr', function () {
                    $('[data-toggle="tooltip_source{{ $call->cdr_id }}"]').tooltip({
                        trigger: 'hover',
                        html: true
                    });
                });
                $('#example').on('mouseover', 'tr', function () {
                    $('[data-toggle="tooltip_destination{{ $call->cdr_id }}"]').tooltip({
                        trigger: 'hover',
                        html: true
                    });
                });
                   
                    </script>
                  
                    <td>@if($call->calltype == '1') Local @elseif($call->calltype == '2') Incoming @elseif($call->calltype == '3') Outgoing @endif</td>
                    <td>{{ $call->billsec }}</td>
                    <td>
                       
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
                          if (preg_match('/[\[\]\']/', $price_data))

                                {
                                  

                                $postition =strpos($price_data, "[");
                                $first_position= $postition+1;
                                $second_position = $postition+3;
                              
                              for($x= $price_data[$first_position]; $x <= $price_data[$second_position]; $x++)
                              
                               {

                                $new_data =  str_replace("[".$price_data[$first_position]."-".$price_data[$second_position]."]", $x, $price_data);
                                if(strlen($new_data) == strlen($call_data) && $call->calltype == $rate->type){

                                  $xyz = add_some_extra($new_data,$call_data,$call,$rate);
                                    
                               
                               
                                }
                                else{
                                 
                                  break;
                                }
                                
                                }
                                

                                }
                                else{
                                  if(strlen($price_data) == strlen($call_data) && $call->calltype == $rate->type){
                                    $xyz =  add_some_extra($price_data,$call_data,$call,$rate);
                                  }
                                  else{
                                    echo $out->p_name;
                                    break;
                                  }
                                }
                                                          
                            
                          @endphp
                      @endforeach
                    @php
                    if($xyz->p_name == "" ){
                      if($call->calltype == '2'){
                           echo "Recebida";
                      }
                      elseif($call->calltype == '3'){
                             echo "Sem Tarifa";
                        }
                    } 
                    else{
                      echo $xyz->p_name;
                    }
                    
                         
                      
                    
                   @endphp
                    </td>
                    <td>@php echo number_format(floatval($xyz->c_rate), 2, ',', '');  @endphp</td>
                    <td>@php  
                      if($free == true){
                        echo "Free";
                      }
                      else{
                         echo number_format(floatval($xyz->c_cost), 2, ',', '');
                      }
                      @endphp</td>
                  </tr>
                   @endif
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
                        <td>@php echo number_format(floatval($xyz->t_cost), 2, ',', ''); @endphp</td>
                      </tr>
                    </tfoot>             
                </table>
                    </div>
                 