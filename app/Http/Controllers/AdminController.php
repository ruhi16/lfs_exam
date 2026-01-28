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

    public function marksEntry($exam_detail_id = null, $myclass_section_id = null, $myclass_subject_id = null)
    {
        // If parameters are provided, pass them to the view
        if ($exam_detail_id && $myclass_section_id && $myclass_subject_id) {
            return view('marks-entry', compact('exam_detail_id', 'myclass_section_id', 'myclass_subject_id'));
        }
        
        // Otherwise, show the general marks entry page
        return view('marks-entry');
    }
}