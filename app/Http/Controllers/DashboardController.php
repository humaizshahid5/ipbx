<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pricing;

use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
   

    public function index()
    {
        $start_date = Date('y-m-d', strtotime('-30 days'));
        $end_date = Date('y-m-d');
        $calls_count =   DB::table('cdr')->count();
        $calls_today =   DB::table('cdr')->where('calldate', 'like', date("Y-m-d")."%")->count();
        $users_count =   DB::table('users')->count();
        $calls =   DB::table('cdr')->where('calltype', '=', '3')->Where('duration', '>=', '1' )->whereBetween('calldate', [$start_date, $end_date])->orderBY('calldate', 'DESC')->get();
        $calls_total =   DB::table('cdr')->where('calltype', '=', '3')->get();

        $rates =   DB::table('pricings')->get();
       
        return view('dashboard', [
            'calls_count' => $calls_count,
            'calls_today' => $calls_today,
            'users_count' => $users_count,
            'calls' => $calls,
            'calls_total' => $calls_total,
            'rates' => $rates
        ]);
    }

}
