<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
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
    use WithPagination;
    
    // Public properties for search and filtering
    public $search = '';
    public $selectedSession = '';
    public $selectedExamName = '';
    
    // Modal properties
    public $isOpen = false;
    public $isEdit = false;
    public $examDetailId = null;
    
    // Form properties
    public $session_id, $exam_name_id, $exam_type_id, $exam_part_id, $exam_mode_id;
    public $selectedClasses = [];
    public $name, $description, $order_index, $is_optional, $school_id, $user_id, $approved_by;
    public $is_active = true, $is_finalized = false, $status = '', $remarks = '';
    
    // Dynamic form arrays
    public $examParts = [];
    public $examTypes = [];
    public $examModes = [];
    
    // Properties for enhanced modal
    public $selectedExamTypes = [];
    public $selectedExamParts = [];
    
    protected $paginationTheme = 'tailwind';
    
    public function render()
    {
        $groupedData = $this->getGroupedExamData();
        
        return view('livewire.exam05-exam-detail-comp', [
            'groupedData' => $groupedData,
            'sessions' => Session::all(),
            'examNames' => Exam01Name::all(),
            'classes' => Myclass::all(),
            'parts' => Exam03Part::all(),
            'types' => Exam02Type::all(),
            'modes' => Exam04Mode::all(),
            'schools' => School::all(),
            'users' => User::all()
        ]);
    }
    
    public function getGroupedExamData()
    {
        $query = Exam05Detail::with(['examName', 'myclass', 'examPart', 'examType', 'examMode', 'session']);
        
        // Apply filters
        if ($this->selectedSession) {
            $query->where('session_id', $this->selectedSession);
        }
        
        if ($this->selectedExamName) {
            $query->where('exam_name_id', $this->selectedExamName);
        }
        
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }
        
        // Get all exam details
        $examDetails = $query->get();
        
        // Group by class first, then by exam_name, then by exam_type
        $grouped = collect();
        
        // Initialize structure with all classes and exam_names
        $classes = Myclass::all();
        $examNames = Exam01Name::all();
        
        foreach ($classes as $class) {
            $grouped->put($class->id, collect());
            
            foreach ($examNames as $examName) {
                $grouped[$class->id]->put($examName->id, collect());
                
                // Get exam types for this exam name from the exam details
                $examTypeIds = $examDetails->where('exam_name_id', $examName->id)->pluck('exam_type_id')->unique();
                
                foreach ($examTypeIds as $examTypeId) {
                    $examType = Exam02Type::find($examTypeId); // Get the exam type object
                    
                    if ($examType) { // Only proceed if the exam type exists
                        $grouped[$class->id][$examName->id]->put($examType->id, collect());
                        
                        // Get exam details for this combination
                        $details = $examDetails->filter(function ($detail) use ($class, $examName, $examType) {
                            return $detail->myclass_id == $class->id && 
                                   $detail->exam_name_id == $examName->id && 
                                   $detail->exam_type_id == $examType->id;
                        });
                        
                        $grouped[$class->id][$examName->id][$examType->id] = $details;
                    }
                }
            }
        }
        
        return $grouped;
    }
    
    public function updatedSelectedSession()
    {
        $this->resetPage();
    }
    
    public function updatedSelectedExamName()
    {
        $this->resetPage();
    }
    
    public function updatedSearch()
    {
        $this->resetPage();
    }
    
    public function create()
    {
        $this->resetInputFields();
        $this->isEdit = false;
        $this->openModal();
    }
    
    public function edit($id)
    {
        $examDetail = Exam05Detail::findOrFail($id);
        
        $this->examDetailId = $id;
        $this->session_id = $examDetail->session_id;
        $this->exam_name_id = $examDetail->exam_name_id;
        $this->selectedClasses = [$examDetail->myclass_id]; // Set the selected class for editing
        $this->exam_type_id = $examDetail->exam_type_id;
        $this->exam_part_id = $examDetail->exam_part_id;
        $this->exam_mode_id = $examDetail->exam_mode_id;
        $this->name = $examDetail->name;
        $this->description = $examDetail->description;
        $this->order_index = $examDetail->order_index;
        $this->is_optional = $examDetail->is_optional;
        $this->school_id = $examDetail->school_id;
        $this->user_id = $examDetail->user_id;
        $this->approved_by = $examDetail->approved_by;
        $this->is_active = $examDetail->is_active;
        $this->is_finalized = $examDetail->is_finalized;
        $this->status = $examDetail->status;
        $this->remarks = $examDetail->remarks;
        
        $this->isEdit = true;
        $this->openModal();
    }
    
    public function store()
    {
        $this->validate([
            'session_id' => 'required|exists:sessions,id',
            'exam_name_id' => 'required|exists:exam01_names,id',
            'selectedClasses' => 'required|array|min:1',
            'selectedClasses.*' => 'required|exists:myclasses,id',
            'exam_type_id' => 'required|exists:exam02_types,id',
            'exam_part_id' => 'required|exists:exam03_parts,id',
            'exam_mode_id' => 'required|exists:exam04_modes,id',
            'name' => 'required|string|max:255',
            'order_index' => 'nullable|integer',
            'school_id' => 'nullable|exists:schools,id',
            'user_id' => 'nullable|exists:users,id',
            'approved_by' => 'nullable|exists:users,id'
        ]);
        
        // Create exam details for each selected class
        foreach ($this->selectedClasses as $classId) {
            Exam05Detail::create([
                'session_id' => $this->session_id,
                'exam_name_id' => $this->exam_name_id,
                'myclass_id' => $classId,
                'exam_type_id' => $this->exam_type_id,
                'exam_part_id' => $this->exam_part_id,
                'exam_mode_id' => $this->exam_mode_id,
                'name' => $this->name,
                'description' => $this->description,
                'order_index' => $this->order_index,
                'is_optional' => $this->is_optional,
                'school_id' => $this->school_id,
                'user_id' => $this->user_id,
                'approved_by' => $this->approved_by,
                'is_active' => $this->is_active,
                'is_finalized' => $this->is_finalized,
                'status' => $this->status,
                'remarks' => $this->remarks
            ]);
        }
        
        session()->flash('message', count($this->selectedClasses) . ' exam detail(s) created successfully.');
        $this->closeModal();
        $this->resetInputFields();
    }
    
    public function update()
    {
        $this->validate([
            'session_id' => 'required|exists:sessions,id',
            'exam_name_id' => 'required|exists:exam01_names,id',
            'selectedClasses' => 'required|array|min:1',
            'selectedClasses.*' => 'required|exists:myclasses,id',
            'exam_type_id' => 'required|exists:exam02_types,id',
            'exam_part_id' => 'required|exists:exam03_parts,id',
            'exam_mode_id' => 'required|exists:exam04_modes,id',
            'name' => 'required|string|max:255',
            'order_index' => 'nullable|integer',
            'school_id' => 'nullable|exists:schools,id',
            'user_id' => 'nullable|exists:users,id',
            'approved_by' => 'nullable|exists:users,id'
        ]);
        
        // For update, we'll update the existing record with the first selected class
        $examDetail = Exam05Detail::findOrFail($this->examDetailId);
        $examDetail->update([
            'session_id' => $this->session_id,
            'exam_name_id' => $this->exam_name_id,
            'myclass_id' => $this->selectedClasses[0], // Use the first selected class for the existing record
            'exam_type_id' => $this->exam_type_id,
            'exam_part_id' => $this->exam_part_id,
            'exam_mode_id' => $this->exam_mode_id,
            'name' => $this->name,
            'description' => $this->description,
            'order_index' => $this->order_index,
            'is_optional' => $this->is_optional,
            'school_id' => $this->school_id,
            'user_id' => $this->user_id,
            'approved_by' => $this->approved_by,
            'is_active' => $this->is_active,
            'is_finalized' => $this->is_finalized,
            'status' => $this->status,
            'remarks' => $this->remarks
        ]);
        
        // If there are multiple classes selected, we need to handle this differently
        // For now, we'll just update the existing record with the first class
        // and inform the user that only the first class is updated in edit mode
        session()->flash('message', 'Exam detail updated successfully for class: ' . Myclass::find($this->selectedClasses[0])->name);
        $this->closeModal();
        $this->resetInputFields();
    }
    
    public function delete($id)
    {
        Exam05Detail::findOrFail($id)->delete();
        session()->flash('message', 'Exam detail deleted successfully.');
    }
    
    public function openModal()
    {
        $this->isOpen = true;
    }
    
    public function closeModal()
    {
        $this->isOpen = false;
    }
    
    public function resetInputFields()
    {
        $this->examDetailId = null;
        $this->session_id = '';
        $this->exam_name_id = '';
        $this->selectedClasses = [];
        $this->exam_type_id = '';
        $this->exam_part_id = '';
        $this->exam_mode_id = '';
        $this->name = '';
        $this->description = '';
        $this->order_index = '';
        $this->is_optional = false;
        $this->school_id = '';
        $this->user_id = '';
        $this->approved_by = '';
        $this->is_active = true;
        $this->is_finalized = false;
        $this->status = '';
        $this->remarks = '';
    }
    
    public function submitForm()
    {
        if ($this->isEdit) {
            $this->update();
        } else {
            $this->store();
        }
    }
    
    private function groupExamDetails()
    {
        $groups = [];
        
        // Group by exam name, then exam type, then exam parts
        foreach ($this->examDetails as $detail) {
            // Skip if detail is null
            if (!$detail) continue;
            
            // Safely get exam name
            $examName = $detail->examName ? $detail->examName->name : 'Unknown Exam';
            
            // Initialize exam name group if not exists
            if (!isset($groups[$examName])) {
                $groups[$examName] = [
                    'exam_name' => $examName,
                    'exam_types' => []
                ];
            }
            
            // Safely get exam type
            $examTypeName = $detail->examType ? $detail->examType->name : 'Unknown Type';
            
            // Initialize exam type group if not exists within exam name
            if (!isset($groups[$examName]['exam_types'][$examTypeName])) {
                $groups[$examName]['exam_types'][$examTypeName] = [
                    'exam_type_name' => $examTypeName,
                    'exam_parts' => []
                ];
            }
            
            // Safely get exam part
            $examPartName = $detail->examPart ? $detail->examPart->name : 'Unknown Part';
            
            // Initialize exam part group if not exists within exam type
            if (!isset($groups[$examName]['exam_types'][$examTypeName]['exam_parts'][$examPartName])) {
                $groups[$examName]['exam_types'][$examTypeName]['exam_parts'][$examPartName] = [
                    'exam_part_name' => $examPartName,
                    'details' => []
                ];
            }
            
            // Add detail to the appropriate part group
            $groups[$examName]['exam_types'][$examTypeName]['exam_parts'][$examPartName]['details'][] = $detail;
        }
        
        return $groups;
    }
}
