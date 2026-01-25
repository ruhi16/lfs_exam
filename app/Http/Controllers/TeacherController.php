<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\School;
use App\Models\Session;


use App\Models\Teacher;
use App\Models\User;



class TeacherController extends Controller
{
       
    public function index()
    {
        // $teachers = Teacher::all();
        // return $teachers;

        // $school = School::with('sessions')->get();
        // return $school;
        
        // echo json_encode($school);
        // echo $school->sessions;

        $session = Session::with('school')->get();
        

        return $session[0]->school;

        


        // $users = User::with('teacher')->get();
        // return $users;
        // $teachers = Teacher::with('user')->get();
        // return $teachers;


    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show(Teacher $teacher)
    {
        //
    }

    
    public function edit(Teacher $teacher)
    {
        //
    }

    
    public function update(Request $request, Teacher $teacher)
    {
        //
    }

    
    public function destroy(Teacher $teacher)
    {
        //
    }
}
