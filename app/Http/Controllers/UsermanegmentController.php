<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
class UsermanegmentController extends Controller
{
    
   

    public function index()
    {
       
        
       
        $users = User::get();
        return view("users",  [
            'users' => $users
           
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
            toastr()->error('Failed to create a new user');
            return back();
        }

       
    }
    public function del($del, Request $request){
       $query = $request->user()->where('id', $del)->delete();      
       if($query){
        toastr()->info('A user been deleted');
        return back();
    }
    else{
        toastr()->error('Failed to delete a user');
        return back();
    }
    }
    
}