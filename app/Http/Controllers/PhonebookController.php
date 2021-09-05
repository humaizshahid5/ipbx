<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhonebookController extends Controller
{
    public function index(){
        return view("phonebook");
    }
}
