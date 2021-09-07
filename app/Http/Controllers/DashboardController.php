<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pricing;
use App\Http\Middleware;

use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
   
   
    public function index()
    {
        $check =  DB::table('activation')->where('url', '=', url('/'))->Where('status', '=', '1' )->count();
        if ($check == 0 ) {
           
            session(['activation_status' => false]);
        }
        else{
            session(['activation_status' => true]);
        }


        $current_month = Date('Y-m-d', strtotime("first day of this month"));
        $current_date = Date('Y-m-d');
        $start_date = Date('y-m-d', strtotime('-30 days'));
        $end_date = Date('y-m-d', strtotime('+1 days'));
        $outgoing_count =  DB::table('cdr')->where('calltype', '=', '3')->Where('billsec', '>=', '1' )->where('calldate', 'like', date("Y-m-d")."%")->count();
        $incoming_count =  DB::table('cdr')->where('calltype', '=', '2')->Where('billsec', '>=', '1' )->where('calldate', 'like', date("Y-m-d")."%")->count();
        $local_count =  DB::table('cdr')->where('calltype', '=', '1')->Where('billsec', '>=', '1' )->where('calldate', 'like', date("Y-m-d")."%")->count();
        $m_outgoing_count =  DB::table('cdr')->where('calltype', '=', '3')->Where('billsec', '>=', '1' )->wherebetween('calldate', [$start_date,$end_date])->count();
        $m_incoming_count =  DB::table('cdr')->where('calltype', '=', '2')->Where('billsec', '>=', '1' )->wherebetween('calldate', [$start_date,$end_date])->count();
        $m_local_count =  DB::table('cdr')->where('calltype', '=', '1')->Where('billsec', '>=', '1' )->wherebetween('calldate', [$start_date,$end_date])->count();
        $calls_count =   DB::table('cdr')->Where('billsec', '>=', '1' )->wherebetween('calldate', [$start_date,$end_date])->count();
        $users_count =   DB::table('users')->count();
        $calls =   DB::table('cdr as call')
        ->leftJoin('phonebooks as s_name', 'call.source', '=', 's_name.number')
        ->leftJoin('phonebooks as d_name', 'call.destination', '=', 'd_name.number')
        ->where('calltype', '=', '3')->Where('billsec', '>=', '1' )
        ->wherebetween('calldate', [$start_date,$end_date])->orderBY('calldate', 'DESC')
        ->select('call.*', 'd_name.number as d_number', 'd_name.name as d_name','s_name.name as s_name','s_name.number as s_number','s_name.id as s_id','d_name.id as d_id')
        ->get();
       
        $calls_total =   DB::table('cdr')->Where('billsec', '>=', '1' )->whereDate('calldate', '>=', $start_date)->whereDate('calldate', '<=', $end_date)->orderBY('calldate', 'DESC')->get();

        $rates =   DB::table('pricings')->get();

       
       
       
        return view('dashboard', [
            'calls_count' => $calls_count,
            'users_count' => $users_count,
            'calls' => $calls,
            'calls_total' => $calls_total,
            'rates' => $rates,
            'outgoing_count' => $outgoing_count,
            'incoming_count' => $incoming_count,
            'local_count' => $local_count,
            'm_outgoing_count' => $m_outgoing_count,
            'm_local_count' => $m_local_count,
            'm_incoming_count' => $m_incoming_count,
            
            


        ]);
    }
 

}
