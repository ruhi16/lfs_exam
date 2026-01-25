<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function dashboard(){
        
        return view('components.office-dashboard');
    }

    
}
