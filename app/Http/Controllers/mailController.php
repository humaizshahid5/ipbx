<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class mailController extends Controller
{
    public function index(){
      
            $get = DB::table('mail_settings')->get();
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
                'from' => ['required'],
    
            ]);
       
    
            $mail_update = DB::table('mail_settings')->update($request->except('_token'));
    
            if($mail_update){
                toastr()->success('Email Client settings has been updated');
                return back();
            }
            else{
                toastr()->error('Failed to update');
                return back();
            }
    
        }
}
