<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Exam07AnsscrDist;
use Illuminate\Support\Facades\Auth;

class Subadmin10MarksEntryComp extends Component
{
    public $teacherId;

    public function mount($teacherId = null)
    {
        $this->teacherId = $teacherId ?? Auth::user()->teacher_id;
    }

    public function render()
    {
        $groupedDistributions = collect();

        if ($this->teacherId) {
            $groupedDistributions = Exam07AnsscrDist::where('teacher_id', $this->teacherId)
                ->with([
                    'examClassSubject.examDetail.examName',
                    'examClassSubject.examDetail.examType',
                    'examClassSubject.examDetail.examPart',
                    'examClassSubject.examDetail.examMode',
                    'examClassSubject.subject',
                    'examClassSubject.myclass',
                    'myclassSection.section',
                    'myclassSection.myclass'
                ])
                ->get()
                ->sortBy(function ($item) {
                    return ($item->examClassSubject->examDetail->examName->name ?? '') .
                        ($item->examClassSubject->examDetail->examPart->name ?? '');
                })
                ->groupBy(function ($item) {
                    return $item->examClassSubject->examDetail->examType->name ?? 'Unknown Type';
                });
        }

        return view('livewire.subadmin10-marks-entry-comp', [
            'groupedDistributions' => $groupedDistributions
        ]);
    }
}
