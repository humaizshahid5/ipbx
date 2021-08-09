<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
class UsermanegmentController extends Controller
{
    
   

    public function index()
    {
       
        $role = auth()->user()->role;
        if($role == '0'){
        return redirect()->route('dashboard');
        }
        else{
        $users = User::Paginate(10);
        return view("users",  [
            'users' => $users
           
        ]);
    }
    }
    public function create(Request $request){
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required'],

        ]);

        $request->user()->create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,

        ]);

        return back();
    }
    public function del($del, Request $request){
        $request->user()->where('id', $del)->delete();      
        return back();
    }
    
}