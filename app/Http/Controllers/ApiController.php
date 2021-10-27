<?php

namespace App\Http\Controllers;
use App\Models\Api; 
use DB;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function all_record(){
        $apis = Api::get();
        return $apis;
    }
    public function index()
    {
        
        $apis = Api::get();
        return view("api",  [
            'apis' => Self::all_record()
           
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
            toastr()->warning('Failed to create a new API');
            return back();
        }
        
    }
    public function del($del, Request $request)
    {
        $query = DB::table('apis')->where('id', $del)->delete();
        if($query){
            toastr()->error('An API  has been deleted');
            return back();
        }
        else{
            toastr()->warning('Failed to delete an API');
            return back();
        }
       
    }
    public function api_edit($edit, Request $request)
    {
        $query = DB::table('apis')->where('id', $edit)->count();
        if($query > 0)
        {
            $get = DB::table('apis')->where('id', $edit)->get();
            return view("api", [
                'data' => $get,
                'apis' => Self::all_record()
            ]);
        }
        else{
            toastr()->warning('Invalid ID');
            return redirect('phonebook');
        }
        
    }
    public function edit($edit, Request $request){
        $this->validate($request, [
            'url' => ['required'],
            'key' => ['required'],
          

        ]);

       $query=  Api::where('id', '=', $edit)->update([
            'url' => $request->url,
            'key' => $request->key,
          

        ]);
        if($query){
            toastr()->info('Record Updated');
            return back();
        }
        else{
            toastr()->warning('Failed to Update');
            return back();
        }
        
    }
}
