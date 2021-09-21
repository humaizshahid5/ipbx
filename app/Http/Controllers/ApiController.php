<?php

namespace App\Http\Controllers;
use App\Models\Api; 
use DB;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index()
    {
        
        $apis = Api::get();
        return view("api",  [
            'apis' => $apis
           
        ]);
    }
    public function create(Request $request){
        $this->validate($request, [
            'url' => ['required'],
            'key' => ['required'],
          

        ]);

       $query=  Api::create([
            'url' => $request->url,
            'key' => $request->key,
          

        ]);
        if($query){
            toastr()->success('A new API has been created');
            return back();
        }
        else{
            toastr()->error('Failed to create a new API');
            return back();
        }
        
    }
    public function del($del, Request $request)
    {
        $query = DB::table('apis')->where('id', $del)->delete();
        if($query){
            toastr()->info('An API  has been deleted');
            return back();
        }
        else{
            toastr()->error('Failed to delete an API');
            return back();
        }
       
    }
}
