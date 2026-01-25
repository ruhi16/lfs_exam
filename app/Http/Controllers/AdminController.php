<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){
        return view('components.admin-dashboard');
    }

    public function admission($myclassSection_id)
    {
        // echo ($myclassSection_id);
        return view('livewire.admin-admission-component', ['myclassSection_id' => $myclassSection_id]);
    }
}