<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Report; 
use  Illuminate\Validation;
use Illuminate\Support\Facades\DB;
use  Illuminate\Database\Query;
use App\Exceptions\InvalidOrderException;
use Mail;


class ReportController extends Controller
{
    public function all_record(){
        $reports = Report::get();
        return $reports;
    }
    public function index()
    {
        $reports = Report::get();
        return view("report",  [
            'reports' => Self::all_record()
           
    
        ]);
       
    }
    public function store(Request $request){
        $this->validate($request, [
            'email' => ['required'],
            'period' => ['required'],
            'range' => ['required'],
            'type' => ['required'],
          

        ]);
    
       if($request->period >= 1 && $request->period <= 9)
       {
           $period = "0".$request->period;
       }
       else{
           $period = $request->period;
       }
        $reports = Report::create([
            'email' => $request->email,
            'period' => $period,
            'range' => $request->range,
            'type' => serialize($request->type),
            'source' => $request->source,
            'destination' => $request->destination,
            'duration' => $request->duration
        ]);
        if($reports){
            toastr()->success('A new report has been added');
            return back();
        }
        else{
            toastr()->warning('Failed to add a new report');
            return back();
        }

        
    }
    public function destroy($del, Request $request)
    {
       $query = DB::table('reports')->where('id', $del)->delete();
        if($query){
            toastr()->error('A report has been deleted');
            return back();
        }
        else{
            toastr()->warning('Failed to delete a  report');
            return back();
        }

        
    }
    public function auto_report(){
       
      print( Date('d'));
        $users_data = DB::table('reports')->where('period' , '=' ,  Date('d'))->get();
        foreach($users_data as $user_data)
        {
          
            $details = [
                'id' => $user_data->id,
                'to' => $user_data->email,
                'from' => env("MAIL_USERNAME"),
                'url' => env("APP_URL"),
                'type' => $user_data->type,
                'range' => $user_data->range,
                'source' => $user_data->source,
                'destination' => $user_data->destination,
                'duration' => $user_data->duration,
                "body"  => 'Hello'
            ];
    
          $check =  \Mail::to($user_data->email)->send(new \App\Mail\Mail($details));
         dd($check);
            if (Mail::failures()) {
                dd("Failure");

            }
            
            print("Success");
        }
       
    }
    public function report($id, Request $request){
        $users_data = DB::table('reports')->where('id', $id)->get();
      
        foreach($users_data as $user_data)
      {
        
              if($user_data->range == 1)
              {
               
                 $start_date = Date('Y-m-d', strtotime('-16 days'));
                 $end_date = Date('y-m-d', strtotime('-1 days'));
              }
              elseif($user_data->range == '2')
              {
                $start_date = Date('Y-m-d', strtotime('-31 days'));
                $end_date = Date('Y-m-d', strtotime('-1 days'));

              }
              else{
                $start_date = Date('Y-m-d', strtotime("first day of previous month"));
                $end_date = Date('Y-m-d', strtotime("last day of previous month"));

              }

        
            $filters = [
                'source' => $user_data->source,
                'destination'    => $user_data->destination,
                'duration'    => $user_data->duration,
                'type'    => $user_data->type,

            ];
         
            $calls =DB::table('cdr as call')
            ->leftJoin('phonebooks as s_name', 'call.source', '=', 's_name.number')
            ->leftJoin('phonebooks as d_name', 'call.destination', '=', 'd_name.number') 
            ->where(function ($query) use ($filters) {
              if ($filters['source']) {
                $query->where('source', '=', $filters['source']);
            }
             if ($filters['destination']) {
                $query->where('destination', '=', $filters['destination']);
            }
           
            if ($filters['duration']){
                $query->where('billsec', '>=', $filters['duration']);
            }
           
                $query->whereIN('calltype' , unserialize($filters['type']));
            
 
            })
            ->Where('billsec', '>=', '1' )->whereDate('calldate', '>=', $start_date)->whereDate('calldate', '<=', $end_date)->orderBY('calldate', 'DESC')->select('call.*', 'd_name.number as d_number', 'd_name.name as d_name','s_name.name as s_name','s_name.number as s_number','s_name.id as s_id','d_name.id as d_id')->get();;

        $rates =   DB::table('pricings')->get();
        return view("generate",  [
            'calls' => $calls,
            'rates' => $rates
           
        ]);
    
    }
    }

    public function sendnow($send, Request $request){
       
     

      $users_data = DB::table('reports')->where('id', $send)->get();
      foreach($users_data as $user_data)
      {


        $details = [
            'id' => $user_data->id,
            'to' => $user_data->email,
            'from' => env("MAIL_USERNAME"),
            'url' => env("APP_URL"),
            'type' => $user_data->type,
            'range' => $user_data->range,
            'source' => $user_data->source,
            'destination' => $user_data->destination,
            'duration' => $user_data->duration,

            "body"  => 'Hello'
        ];

       
       try {
        \Mail::to($user_data->email)->send(new \App\Mail\Mail($details));
        toastr()->info('Email report has been sent');
        return back();
       
       }
       catch(\Exception $e){
       dd($e);
       }

       
    }

    }
    public function report_edit($edit, Request $request)
    {
        $query = DB::table('reports')->where('id', $edit)->count();
        if($query > 0)
        {
            $get = DB::table('reports')->where('id', $edit)->get();
            return view("report", [
                'data' => $get,
                'reports' => Self::all_record()
            ]);
        }
        else{
            toastr()->warning('Invalid ID');
            return redirect('report');
        }
        
    }
    public function edit($edit,Request $request){

        $this->validate($request, [
            'email' => ['required'],
            'period' => ['required'],
            'range' => ['required'],
            'type' => ['required'],
          

        ]);
    
       if($request->period >= 1 && $request->period <= 9)
       {
           $period = "0".$request->period;
       }
       else{
           $period = $request->period;
       }
      
        $reports = Report::where('id', '=' , $edit)->update([
            'email' => $request->email,
            'period' => $period,
            'range' => $request->range,
            'type' => serialize($request->type),
            'source' => $request->source,
            'destination' => $request->destination,
            'duration' => $request->duration
        ]);
        if($reports){
            toastr()->info('Record Updated');
            return back();
        }
        else{
            toastr()->warning('Failed to Update');
            return back();
        }

        
    }

}
