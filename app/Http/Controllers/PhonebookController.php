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


}
