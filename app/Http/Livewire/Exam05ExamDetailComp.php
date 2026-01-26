<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Exam05Detail;
use App\Models\Exam01Name;
use App\Models\Myclass;
use App\Models\Exam03Part;
use App\Models\Exam04Mode;
use App\Models\Session;
use App\Models\School;
use App\Models\User;
use App\Models\Exam02Type;

class Exam05ExamDetailComp extends Component
{
    public $examDetails;
    public $groupedData;
    public $search = '';
    public $selectedSession = '';
    public $selectedSchool = '';
    public $isOpen = 0;
    public $name, $description, $myclass_id, $exam_name_id, $exam_type_id, $exam_part_id, $exam_mode_id, $order_index, $is_optional, $session_id, $school_id, $user_id, $approved_by, $is_active, $is_finalized, $status, $remarks, $exam05DetailId;
    
    public function mount()
    {
        $this->loadData();
        $this->resetInputFields();
    }
    
    public function loadData()
    {
        // Load exam details with all relationships
        $query = Exam05Detail::with([
            'examName',
            'myclass',
            'examPart',
            'examMode',
            'session',
            'user',
            'approvedBy'
        ])->where('is_active', true);
        
        // Apply filters if selected
        if ($this->selectedSession) {
            $query->where('session_id', $this->selectedSession);
        }
        
        if ($this->selectedSchool) {
            $query->where('school_id', $this->selectedSchool);
        }
        
        $this->examDetails = $query->get();
        
        // Ensure we have a collection to avoid null errors
        if (!$this->examDetails) {
            $this->examDetails = collect([]);
        }
        
        // Group data by exam name
        $this->groupedData = $this->groupExamDetails();
    }
    
    private function groupExamDetails()
    {
        $groups = [];
        
        // Group by exam name
        foreach ($this->examDetails as $detail) {
            // Skip if detail is null
            if (!$detail) continue;
            
            // Safely get exam name
            $examName = $detail->examName ? $detail->examName->name : 'Unknown Exam';
            
            if (!isset($groups[$examName])) {
                $groups[$examName] = [
                    'exam_name' => $examName,
                    'classes' => [],
                    'details' => []
                ];
            }
            
            // Safely get class name
            $className = $detail->myclass ? $detail->myclass->name : 'Unknown Class';
            if (!in_array($className, $groups[$examName]['classes'])) {
                $groups[$examName]['classes'][] = $className;
            }
            
            // Add detail
            $groups[$examName]['details'][] = $detail;
        }
        
        return $groups;
    }
    
    public function render()
    {
        $sessions = Session::all();
        $schools = School::all();
        $examNames = Exam01Name::all();
        $classes = Myclass::all();
        $examParts = Exam03Part::all();
        $examModes = Exam04Mode::all();
        $examTypes = Exam02Type::all();
        $users = User::all();
        
        return view('livewire.exam05-exam-detail-comp', [
            'groupedData' => $this->groupedData,
            'sessions' => $sessions,
            'schools' => $schools,
            'examNames' => $examNames,
            'classes' => $classes,
            'examParts' => $examParts,
            'examModes' => $examModes,
            'examTypes' => $examTypes,
            'users' => $users
        ]);
    }
    
    public function updatedSelectedSession()
    {
        $this->loadData();
    }
    
    public function updatedSelectedSchool()
    {
        $this->loadData();
    }
    
    public function updatedSearch()
    {
        $this->loadData();
    }
    
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->myclass_id = '';
        $this->exam_name_id = '';
        $this->exam_type_id = '';
        $this->exam_part_id = '';
        $this->exam_mode_id = '';
        $this->order_index = null;
        $this->is_optional = false;
        $this->session_id = '';
        $this->school_id = '';
        $this->user_id = '';
        $this->approved_by = '';
        $this->is_active = true;
        $this->is_finalized = false;
        $this->status = '';
        $this->remarks = '';
        $this->exam05DetailId = null;
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'nullable|string',
            'myclass_id' => 'nullable|integer',
            'exam_name_id' => 'nullable|integer',
            'exam_type_id' => 'nullable|integer',
            'exam_part_id' => 'nullable|integer',
            'exam_mode_id' => 'nullable|integer',
            'order_index' => 'nullable|integer',
            'is_optional' => 'boolean',
            'session_id' => 'nullable|integer',
            'school_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'approved_by' => 'nullable|integer',
            'is_active' => 'boolean',
            'is_finalized' => 'boolean',
            'status' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        if($this->exam05DetailId){
            // Update existing exam detail
            $examDetail = Exam05Detail::find($this->exam05DetailId);
            if($examDetail){
                $examDetail->update([
                    'name' => $this->name,
                    'description' => $this->description ? $this->description : null,
                    'myclass_id' => $this->myclass_id ? $this->myclass_id : null,
                    'exam_name_id' => $this->exam_name_id ? $this->exam_name_id : null,
                    'exam_type_id' => $this->exam_type_id ? $this->exam_type_id : null,
                    'exam_part_id' => $this->exam_part_id ? $this->exam_part_id : null,
                    'exam_mode_id' => $this->exam_mode_id ? $this->exam_mode_id : null,
                    'order_index' => $this->order_index ? $this->order_index : null,
                    'is_optional' => $this->is_optional,
                    'session_id' => $this->session_id ? $this->session_id : null,
                    'school_id' => $this->school_id ? $this->school_id : null,
                    'user_id' => $this->user_id ? $this->user_id : null,
                    'approved_by' => $this->approved_by ? $this->approved_by : null,
                    'is_active' => $this->is_active,
                    'is_finalized' => $this->is_finalized,
                    'status' => $this->status ? $this->status : null,
                    'remarks' => $this->remarks ? $this->remarks : null,
                ]);
            }
        } else {
            // Create new exam detail
            Exam05Detail::create([
                'name' => $this->name,
                'description' => $this->description ? $this->description : null,
                'myclass_id' => $this->myclass_id ? $this->myclass_id : null,
                'exam_name_id' => $this->exam_name_id ? $this->exam_name_id : null,
                'exam_type_id' => $this->exam_type_id ? $this->exam_type_id : null,
                'exam_part_id' => $this->exam_part_id ? $this->exam_part_id : null,
                'exam_mode_id' => $this->exam_mode_id ? $this->exam_mode_id : null,
                'order_index' => $this->order_index ? $this->order_index : null,
                'is_optional' => $this->is_optional,
                'session_id' => $this->session_id ? $this->session_id : null,
                'school_id' => $this->school_id ? $this->school_id : null,
                'user_id' => $this->user_id ? $this->user_id : null,
                'approved_by' => $this->approved_by ? $this->approved_by : null,
                'is_active' => $this->is_active,
                'is_finalized' => $this->is_finalized,
                'status' => $this->status ? $this->status : null,
                'remarks' => $this->remarks ? $this->remarks : null,
            ]);
        }

        session()->flash('message', $this->exam05DetailId ? 'Exam Detail Updated Successfully.' : 'Exam Detail Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
        $this->loadData();
    }

    public function edit($id)
    {
        $examDetail = Exam05Detail::findOrFail($id);
        $this->exam05DetailId = $id;
        $this->name = $examDetail->name;
        $this->description = $examDetail->description;
        $this->myclass_id = $examDetail->myclass_id;
        $this->exam_name_id = $examDetail->exam_name_id;
        $this->exam_type_id = $examDetail->exam_type_id;
        $this->exam_part_id = $examDetail->exam_part_id;
        $this->exam_mode_id = $examDetail->exam_mode_id;
        $this->order_index = $examDetail->order_index;
        $this->is_optional = $examDetail->is_optional;
        $this->session_id = $examDetail->session_id;
        $this->school_id = $examDetail->school_id;
        $this->user_id = $examDetail->user_id;
        $this->approved_by = $examDetail->approved_by;
        $this->is_active = $examDetail->is_active;
        $this->is_finalized = $examDetail->is_finalized;
        $this->status = $examDetail->status;
        $this->remarks = $examDetail->remarks;

        $this->openModal();
    }

    public function delete($id)
    {
        Exam05Detail::find($id)->delete();
        session()->flash('message', 'Exam Detail Deleted Successfully.');
        $this->loadData();
    }

    public function exportData()
    {
        // Placeholder for export functionality
        // In a real implementation, this would export the data to CSV, Excel, or PDF
        session()->flash('message', 'Export functionality would be implemented here.');
    }
}
