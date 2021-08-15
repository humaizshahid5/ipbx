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
        $end_date = Date('y-m-d');
        $calls =   DB::table('cdr')->where('calltype', '=', '3')->Where('duration', '>=', '1' )->whereBetween('calldate', [$start_date, $end_date])->orderBY('calldate', 'DESC')->get();
        $rates =   DB::table('pricings')->get();
        return view("calls",  [
            'calls' => $calls,
            'rates' => $rates
           
        ]);

        
    }
    public function search(Request $request)
    {
      
        if((!empty($request->fromdate) && is_null($request->todate)) || (!empty($request->todate) && is_null($request->fromdate))){
            $this->validate($request, [
                'todate' => 'required',
                'fromdate' => 'required'                
            ]);
          
        }
       
        
     $filters = [
        'source' => $request->source,
        'destination'    => $request->destination,
        'type'    => $request->type,
        'duration'    => $request->duration,
        'from'    => $request->fromdate,
        'to'    => $request->todate,




    ];
 
  $calls = DB::table('cdr')->where(function ($query) use ($filters) {
        if ($filters['from']) {
                $query->whereBetween('calldate', [$filters['from'], $filters['to']]);
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
            $query->where('duration', '>=', $filters['duration']);
        }
    })->get();

        $rates =   DB::table('pricings')->get();

        return view("calls",  [
            'calls' => $calls,
            'rates' => $rates
           
        ]);
    }
}
   