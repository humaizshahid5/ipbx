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

        Api::create([
            'url' => $request->url,
            'key' => $request->key,
          

        ]);

        return back();
    }
    public function del($del, Request $request)
    {
        DB::table('apis')->where('id', $del)->delete();
        return back();
    }
}
