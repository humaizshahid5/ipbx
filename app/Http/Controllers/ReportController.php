<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Report; 
use  Illuminate\Validation;
use Illuminate\Support\Facades\DB;
use  Illuminate\Database\Query;
use Mail;


class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::Paginate(10);
        return view("report",  [
            'reports' => $reports
           
    
        ]);
       
    }
    public function store(Request $request){
        $this->validate($request, [
            'email' => ['required'],
            'period' => ['required'],
            'range' => ['required'],
            'type' => ['required'],

            

        ]);
       $senddate = Date('y:m:d', strtotime('+'.$request->period.' days'));
        $reports = Report::create([
            'email' => $request->email,
            'period' => $request->period,
            'range' => $request->range,
            'type' => $request->type,
            'send_date' => $senddate,
            'download_status' => "0",


            

        ]);

        return back();
    }
    public function destroy($del, Request $request)
    {
        DB::table('reports')->where('id', $del)->delete();
        return back();
    }
    public function auto_report(){
      
        $users_data = DB::table('reports')->where('send_date' , '=' ,  Date('Y-m-d'))->get();
        foreach($users_data as $user_data)
        {
            DB::table('reports')
            ->where('id', $user_data->id)
            ->update(['download_status' => '1' , 'send_date' => Date('y-m-d', strtotime('+'.$user_data->period.' days')) ]);
            $details = [
                'id' => $user_data->id,
                'to' => $user_data->email,
                'from' => env("MAIL_USERNAME"),
                'subject' => 'Report',
                'title' => 'Call Report',
                "body"  => 'Hello'
            ];
    
            \Mail::to($user_data->email)->send(new \App\Mail\Mail($details));
    
            if (Mail::failures()) {
                dd("Failure");

            }
            
            dd("Success");
        }
       
    }
    public function report($id, Request $request){
        $users_data = DB::table('reports')->where('id', $id)->where('download_status' , '=' , '1')->get();
      
        foreach($users_data as $user_data)
      {
        
              if($user_data->range == 1)
              {
               
                 $start_date = Date('Y-m-d', strtotime('-14 days'));
                 $end_date = Date('y-m-d', strtotime('+1 days'));
              }
              elseif($user_data->range == '2')
              {
                $start_date = Date('Y-m-d', strtotime('-30 days'));
                $end_date = Date('Y-m-d', strtotime('+1 days'));

              }
              else{
                $start_date = Date('Y-m-d', strtotime("first day of previous month"));
                $end_date = Date('Y-m-d', strtotime("last day of previous month"));

              }

        $calls =   DB::table('cdr')->where('calltype', '=' , $user_data->type)->where('billsec', '>=' , '1')->whereDate('calldate', '>=', $start_date)->whereDate('calldate', '<=', $end_date)->orderBY('calldate', 'DESC')->get();
        $rates =   DB::table('pricings')->get();
        return view("generate",  [
            'calls' => $calls,
            'rates' => $rates
           
        ]);
    
    }
    }

    public function sendnow($send, Request $request){
        DB::table('reports')
              ->where('id', $send)
              ->update(['download_status' => '1']);

      $users_data = DB::table('reports')->where('id', $send)->get();
      foreach($users_data as $user_data)
      {


        $details = [
            'id' => $user_data->id,
            'to' => $user_data->email,
            'from' => env("MAIL_USERNAME", "somedefaultvalue"),
            'subject' => 'Test',
            'title' => 'Test Email',
            "body"  => 'Hello'
        ];

        \Mail::to($user_data->email)->send(new \App\Mail\Mail($details));

        if (Mail::failures()) {
            dd("Email was not send");
        }
        return back();
    }

    }
}
