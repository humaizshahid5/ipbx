<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
use DB;
class UsermanegmentController extends Controller
{
    
   
    public function all_record(){
        $users = User::get();
        return $users;
    }
    public function index()
    {
       
        
       
        $users = User::get();
        return view("users",  [
            'users' => Self::all_record()
           
        ]);
    
    }
    public function create(Request $request){
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required'],

        ]);

       $query = $request->user()->create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,

        ]);
        if($query){
            toastr()->success('A new user has been added');
            return back();
        }
        else{
            toastr()->warning('Failed to create a new user');
            return back();
        }

       
    }
    public function del($del, Request $request){
       $query = $request->user()->where('id', $del)->delete();      
       if($query){
        toastr()->error('A user been deleted');
        return back();
    }
    else{
        toastr()->warning('Failed to delete a user');
        return back();
    }
    }
    
    public function user_edit($edit, Request $request)
    {
        $query = DB::table('users')->where('id', $edit)->count();
        if($query > 0)
        {
            $get = DB::table('users')->where('id', $edit)->get();
            return view("users", [
                'data' => $get,
                'users' => Self::all_record()
            ]);
        }
        else{
            toastr()->warning('Invalid ID');
            return redirect('phonebook');
        }
        
    }
    public function edit($edit, Request $request){



        $get = User::where('id' ,'=' , $edit)->first();
        
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$get->id],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required'],

        ]);
      
        if ($request->get('password') == '') {
            $query =  User::where('id' , '=' , $edit)->update($request->except('password', '_token'));
        } else {
            $request->merge([
                'password' => Hash::make($request->password)
            ]);
            $query =  User::where('id' , '=' , $edit)->update($request->except('_token'));
        }
        
      
        if($query){
            toastr()->info('User has been updated');
            return back();
        }
        else{
            toastr()->warning('Failed to update');
            return back();
        }

    }
}