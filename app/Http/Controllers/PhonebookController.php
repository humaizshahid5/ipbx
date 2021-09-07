<?php

namespace App\Http\Controllers;
use App\Models\Phonebook;
use Illuminate\Http\Request;
use DB;
class PhonebookController extends Controller
{
    public function index(){
        $phonebooks = Phonebook::get();
        return view("phonebook",  [
            'phonebooks' => $phonebooks
           
        ]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'number' => ['required'],
            
           
         


        ]);
   

        $phonebook = Phonebook::create([
            'name' => $request->name,
            'number' => $request->number,
           
           


        ]);

        return back();
    }
    public function del($del, Request $request)
    {
        DB::table('phonebooks')->where('id', $del)->delete();
        return back();
    }
    public function import(){
      $calls =   DB::table('cdr')->get();
        foreach($calls as $call){
            $name = preg_replace("/[^a-zA-Z ]+/", "", $call->clid);
            if($name != " "){
           
           
            
            $number =(int) filter_var($call->clid, FILTER_SANITIZE_NUMBER_INT);  
            if($name != null)
            {

                $phonebook = DB::table('phonebooks')->where('number', '=', $number)->count();
                    if($phonebook == 0)
                    {
                        Phonebook::create([
                                'name' => $name,
                                'number' => $number,
                        ]);
                    }
                
                }
            }   
        }
            return back();
    }
}
