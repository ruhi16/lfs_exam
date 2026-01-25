<?php

namespace App\Http\Livewire;

use App\Models\Answerscriptdistribution;
use App\Models\Examdetails;
use App\Models\Marksentry;
use App\Models\Myclasssection;
use App\Models\Myclasssubject;
use App\Models\Studentcr;
use Livewire\Component;

class SubadminMarksEntryEntityComponent extends Component
{
    public $myclassSection_id;
    public $myclassSubject_id;
    public $examdetail_id;

    public $myclassSection;
    public $myclassSubject;
    public $examdetail;

    public $ansscriptdistribution;
    public $marksentry;

    public $studentcrs;

    public $marks;
    public $cbmarks;

    public $v;
    public $k;

    public function mount($myclassSection_id, $myclassSubject_id, $examdetail_id) 
    {
        $this->myclassSection_id = $myclassSection_id;
        $this->myclassSubject_id = $myclassSubject_id;
        $this->examdetail_id = $examdetail_id;

        $this->myclassSection = Myclasssection::find($myclassSection_id);
        $this->myclassSubject = Myclasssubject::find($myclassSubject_id);
        $this->examdetail = Examdetails::find($this->examdetail_id);

        $this->studentcrs = Studentcr::where('myclass_id', $this->myclassSection->myclass_id)
            ->where('section_id', $this->myclassSection->section_id)
            ->orderBy('roll_no', 'asc')
            ->get();

        $this->ansscriptdistribution = Answerscriptdistribution::where('myclass_id', $this->myclassSection->myclass_id)
            ->where('section_id', $this->myclassSection->section_id)
            ->where('subject_id', $this->myclassSubject->subject_id)
            ->where('examdetail_id', $this->examdetail_id)
            ->get();
            
        $this->marksentry = Marksentry::where('myclasssection_id', $this->myclassSection_id)
            ->where('examdetail_id', $this->examdetail_id)            
            ->where('myclasssubject_id', $this->myclassSubject_id)
            ->get();

        // dd($this->marksentry);

        $this->marks = [];
        $this->cbmarks = [];
        // $this->marks[67] = 5;
        // foreach ($this->studentcrs as $studentcr) {
        //     $this->marks[$studentcr->id] = $this->marksentry->where('studentcr_id', $studentcr->id) ?? -1;
        //     $this->cbmarks[$studentcr->id] = 0;
        // }
    }

    public function updatedMarks($value, $key)
    {
        // $this->k = $key;    // studentcr_id
        // $this->v = $value;  // marks
        // dd($value, $key);

        $this->submitMarks($key, $value);

        // $this->marks[$key] = $value;
        // echo json_encode($this->marks);
    }

    public function updatedCbmarks($value, $key){
        $this->k = $key;    // studentcr_id
        $this->v = $value;  // marks

        $this->submitMarks($key);
        // $this->cbmarks[$key] = $value;
        // echo json_encode($this->cbmarks);

        // session()->flash('message', 'CBMarks updated to '.$value.' successfully!');
        // if(!$this->cbmarks[$key]){

        //     $this->marks[$key] = '';
        // }
        // echo json_encode($this->cbmarks);
    }

    public function finalize(){

        $ansScrDist = $this->ansscriptdistribution->first();
        $ansScrDist->finalize_dt = date('Y-m-d');   //new \DateTime();
        $ansScrDist->status = 'Done';
        $ansScrDist->save();
        
    }



    public function submitMarks($studentcr_id, $mark_value=-999){
        
        try {
            $marksentry = Marksentry::updateOrCreate([
                'examdetail_id' => $this->examdetail_id,
                'myclasssection_id' => $this->myclassSection_id,
                'myclasssubject_id' => $this->myclassSubject_id,
                'studentcr_id' => (int) $studentcr_id,
                'session_id' => 1,
                'school_id' => 1,
            ],[
                'marks' => (double) $mark_value,
                'status' => 'Done',
            ]);

            // $marksentry->marks = (double) $mark_value;            
            // $marksentry->status = 'Done';
            // $marksentry->save();

            
            session()->flash('message', 'Marks submitted successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error saving marks: ' . $e->getMessage());
        }

        $this->marksentry = Marksentry::where('myclasssection_id', $this->myclassSection_id)
            ->where('examdetail_id', $this->examdetail_id)            
            ->where('myclasssubject_id', $this->myclassSubject_id)
            ->get();

    }
    




    public function render()
    {
        return view('livewire.subadmin-marks-entry-entity-component');
    }
}
