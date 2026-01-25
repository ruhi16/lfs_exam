<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function admission($myclassSection_id)
    {
        return view('livewire.admin-admission-component');
    }
}
