<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Teacher;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        // echo "Super Admin";
        // $teachers = Teacher::with('user')->get();
        // $teachers = Teacher::with('user')->get();
        // echo( $teachers );
        // foreach($teachers as $teacher){
        //     echo($teacher->user . '</br>');
        // }

        // echo(json_encode( $teachers->user() ));
        return view('superadmin-dashboard');
    }

    
}
