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
       
        return view("calls");

        
    }
    public function search(Request $request)
    {
        $this->validate($request, [
            'fromdate' => ['required'],
            'todate' => ['required']

        ]);

       
        
     $filters = [
        'source' => $request->source,
        'destination'    => $request->destination,
        'type'    => $request->type,
        'duration'    => $request->duration,
        'from'    => Date($request->fromdate),
        'to'    => Date($request->todate),

        




    ];

    

  

  $calls =    DB::table('cdr as call')
  ->leftJoin('phonebooks as s_name', 'call.source', '=', 's_name.number')
  ->leftJoin('phonebooks as d_name', 'call.destination', '=', 'd_name.number')
  ->where(function ($query) use ($filters) {
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
           
            $query->whereIN('calltype' , $filters['type']);
        }
        if ($filters['duration']) {
            $query->where('billsec', '>=', $filters['duration']);
        }
    })
    ->Where('billsec', '>=', '1' )->orderby('calldate' , 'DESC')
    ->select('call.*', 'd_name.number as d_number', 'd_name.name as d_name','s_name.name as s_name','s_name.number as s_number','s_name.id as s_id','d_name.id as d_id')
    ->paginate(25);

        $rates =   DB::table('pricings')->get();

        return view("calls", compact('calls') , [
           
            'rates' => $rates
           
        ]);

    }
}
   