<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //This method will show dashboard to customers
    public function index(){
        return view('dashboard');
    }
}
