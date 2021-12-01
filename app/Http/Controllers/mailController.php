<?php

namespace App\Http\Controllers;
use DB;
use Artisan;
use Illuminate\Http\Request;
use Mail;
use Database\Seeds\MailSeeder;

class mailController extends Controller
{
    public function index(){
      
            $count = DB::table('mail_settings')->count();
            if($count == "0"){
                Artisan::call("db:seed", ['--class' => "MailSeeder"]);
                $get = DB::table('mail_settings')->get();
            }
            else{
                $get = DB::table('mail_settings')->get();
            }

            return view("mail", [
                'data' => $get
            ]);
        }
       
        public function update(Request $request){
            
            $this->validate($request, [
                'username' => ['required'],
                'password' => ['required'],
                'driver' => ['required'],
                'host' => ['required'],
                'encryption' => ['required'],
                'port' => ['required'],
                'mail_from' => ['required'], 
                'mail_subject' => ['required'],
                'mail_from_address' => ['required']
                

    
            ]);
       
  
            
            try {
                $mail_update = DB::table('mail_settings')->update($request->except('_token'));
                toastr()->info('Mail settings has been updated');
                return back();
               
               }
               catch(\Exception $e){
                toastr()->warning($e);
                return back();
               }
            
    
            
        }
        public function test_mail(Request $request){
            $this->validate($request, [
                'email' => ['required','email']
            ]);
            try {
              
                \Mail::to($request->email)->send(new \App\Mail\testmail());
                toastr()->info('And email report has been sent');
                return back();
               
               }
               catch(\Exception $e){
                dd($e);
               }
            
        }
}
