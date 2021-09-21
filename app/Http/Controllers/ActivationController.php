<?php

namespace App\Http\Controllers;
use App\Models\Activate; 
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;

class ActivationController extends Controller
{
    public function index(){
       
        if(session()->get('activation_status') == true)
        {
            return redirect("dashboard"); 
        }
        return view("activate");
    }

    public function activate(Request $request){
       
     

        $this->validate($request, [
            'code' => ['required' , Rule::in(["7ecca9b0e9e64d18b02dd402a74e9078d4551a45"]),]
                
        ]);
        $activate =DB::table('activation')->insert(
            [
            'url' => url('/'), 
            'status' => '1', 
            'created_at' =>  date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ]
           
        );
        if($activate){
            session(['activation_status' => true]);
            toastr()->success('System has been successfully activated');
            return redirect("dashboard");
        }
        else{
            toastr()->error('Failed to activate the system');
            return back();
        }
       
       

      
   
    }
}
