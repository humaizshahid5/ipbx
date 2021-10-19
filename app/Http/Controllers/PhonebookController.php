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

        if($phonebook){
            toastr()->success('A new phonenumber has been added');
            return back();
        }
        else{
            toastr()->warning('Failed to add a new phonenumber');
            return back();
        }

    }
    public function del($del, Request $request)
    {
        $query = DB::table('phonebooks')->where('id', $del)->delete();
        if($query){
            toastr()->error('A phonenumber has been deleted');
            return back();
        }
        else{
            toastr()->warning('Failed to delete a phonenumber');
            return back();
        }

    }
    public function get_edit($edit, Request $request)
    {
        $query = DB::table('phonebooks')->where('id', $edit)->count();
        if($query > 0)
        {
            $get = DB::table('phonebooks')->where('id', $edit)->get();
            return view("edit_phonebook", [
                'data' => $get
            ]);
        }
        else{
            toastr()->error('Invalid ID');
            return redirect('phonebook');
        }
        
    }
    public function import(){
        $status = 0;
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
                        $status = 1;
                        Phonebook::create([
                                'name' => $name,
                                'number' => $number,
                        ]);
                    }
                
                }
            }   
        }

        if($status == '1'){
            toastr()->success('Phonebook has been updated');
            return back();
        }
        else{
            toastr()->warning('Nothing to update');
            return back();
        }

    }
    public function edit($edit, Request $request){

        $this->validate($request, [
            'name' => ['required'],
            'number' => ['required'],
            
           
         


        ]);
   

        $phonebook = Phonebook::Where('id', $edit)->update(['name' => $request->name, 'number' => $request->number]);

        if($phonebook){
            toastr()->info('Record has been updated successfully');
            return back();
        }
        else{
            toastr()->warning('Failed to update');
            return back();
        }

    }
}
