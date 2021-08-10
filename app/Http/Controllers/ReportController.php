<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Report; 
use  Illuminate\Validation;
use Illuminate\Support\Facades\DB;
use  Illuminate\Database\Query;
use Swift_SendmailTransport;
use Swift_SmtpTransport;



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
       $senddate = Date('y:m:d', strtotime('+10 days'));
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
    public function report(){

        $calls =   DB::table('cdr')->take('100')->orderBY('cdr_id', 'ASC')->get();
        $rates =   DB::table('pricings')->get();
        return view("generate",  [
            'calls' => $calls,
            'rates' => $rates
           
        ]);
    }

    public function sendnow(){
        $host = "mail.humaizshahid.com";
        $port = "143";
        $username = "support@humaizshahid.com";
        $password = "humaiz5900";
        
        $transport = (new Swift_SmtpTransport("mail.humaizshahid.com", "143"))
        ->setUsername("support@humaizshahid.com")
        ->setPassword("humaiz5900");

    $mailer    = new Swift_Mailer($transport);

    $message   = (new Swift_Message("Test"))
        ->setFrom("support@humaizshahid.com", "Test")
        ->setTo("humaiz.work@gmail.com")
        ->setBody("Hello");


    return $mailer->send($message);
    }

  
}
