<?php

namespace App\Http\Controllers;
use  Illuminate\Database\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class CallsController extends Controller
{
    public function index()
    {
        $start_date = Date('y-m-d', strtotime('-30 days'));
        $end_date = Date('y-m-d', strtotime('+1 days'));
        $calls =   DB::table('cdr')->where('calltype', '=', '3')->Where('billsec', '>=', '1' )->whereBetween('calldate', [$start_date, $end_date])->orderBY('calldate', 'DESC')->get();
        $rates =   DB::table('pricings')->get();
        return view("calls",  [
            'calls' => $calls,
            'rates' => $rates
           
        ]);

        
    }
    public function search(Request $request)
    {
      

       
        
     $filters = [
        'source' => $request->source,
        'destination'    => $request->destination,
        'type'    => $request->type,
        'duration'    => $request->duration,
        'from'    => Date($request->fromdate),
        'to'    => Date($request->todate),

        




    ];

    

  

  $calls = DB::table('cdr')->where(function ($query) use ($filters) {
    if((!empty($request->fromdate) && is_null($request->todate)) || (!empty($request->todate) && is_null($request->fromdate))){
        $this->validate($request, [
            'todate' => 'required',
            'fromdate' => 'required'                
        ]);
       
      
}
if ($filters['from']) {
    $query->whereDate('calldate', '>=', $filters['from'])
    ->whereDate('calldate', '<=', $filters['to']);
}
    
       
  
        if ($filters['source']) {
            $query->where('source', '=', $filters['source']);
        }
         if ($filters['destination']) {
            $query->where('destination', '=', $filters['destination']);
        }
        if ($filters['type']) {
            $query->where('calltype', '=', $filters['type']);
        }
        if ($filters['duration']) {
            $query->where('billsec', '>=', $filters['duration']);
        }
    })->Where('billsec', '>=', '1' )->orderby('calldate' , 'DESC')->get();

        $rates =   DB::table('pricings')->get();

        return view("calls",  [
            'calls' => $calls,
            'rates' => $rates
           
        ]);
    }
}
   