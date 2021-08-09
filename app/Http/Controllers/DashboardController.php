<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pricing;

use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
   

    public function index()
    {
        $calls_count =   DB::table('cdr')->count();
        $calls_today =   DB::table('cdr')->where('calldate', 'like', date("Y-m-d")."%")->count();
        $users_count =   DB::table('users')->count();
        $calls =   DB::table('cdr')->take('100')->orderBY('cdr_id', 'DESC')->get();
        $rates =   DB::table('pricings')->get();
       
        return view('dashboard', [
            'calls_count' => $calls_count,
            'calls_today' => $calls_today,
            'users_count' => $users_count,
            'calls' => $calls,
            'rates' => $rates
        ]);
    }

}
