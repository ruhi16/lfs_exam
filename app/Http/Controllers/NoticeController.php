<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::all();
        // dd($notice);
        return view('notice')
            // ->with('path', $path)
            ->with('notices', $notices)
            ;
    }

    public function display($id)
    {
        $notice = Notice::find($id);
        // dd($notice);
        
        return view('notice-create');
    }

    public function create(){
        echo 'create new';

        return view('notices-create');
    }

    public function store(Request $request){
        echo 'have to store image';
        // dd($request);

        $request->validate([
            'title' => 'required|max:50|string',
            'desc' => 'required|max:255|string',
            'dop' =>'required|date',
            'doe' =>'required|date',
            'fileaddr' => 'nullable|mimes:png,jpg,jpeg,webp,pdf',
            'is_active' => 'sometimes'
        ]);

        $path = NULL;
        $filename = NULL;

        // dd($request);
        if($request->has('fileaddr')){
            $file = $request->file('fileaddr');
            // $extension = $request->file('fileaddr')->extension();
            $extension = $file->getClientOriginalExtension();

            $path = 'upload/notices/';
            $filename = time().'.'.$extension;
            
            $file->move($path, $filename);
        }
        // echo '\nfilename:'.$path.$filename;


        Notice::create([
            'title' => $request->title,
            'desc' => $request->desc,
            'dop' => $request->dop,
            'doe' => $request->doe,            
            'fileaddr' => $path.$filename,
            'is_active' => $request->is_active == true ? 1:0,
        ]);


        return redirect('notices')->with('status','Category Created');
    

    }

    public function show(Notice $notice){

    }

    public function edit(Notice $notice){

    }

    public function update(Request $request, Notice $notice){

    }

    public function destroy(Notice $notice){

    }
}
