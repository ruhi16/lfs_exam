<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Exam10MarksEntry;
use App\Models\Myclass;
use App\Models\MyclassSection;
use App\Models\Studentcr;
use App\Models\MyclassSubject;
use App\Models\Exam05Detail;
use App\Models\Subject;
use App\Models\SubjectType;
use App\Models\Exam01Name;
use App\Models\Exam02Type;
use App\Models\Exam03Part;
use App\Models\Exam04Mode;
use App\Models\Exam06ClassSubject;
use App\Models\Exam08Grade;
use App\Models\Session;
use App\Models\School;
use App\Models\User;

class Exam12ExamMarkRegisterComp extends Component
{
    public $activeTab = 0;
    public $classes;
    public $sections;
    public $students;
    public $examClassSubjects;
    public $examDetails;
    public $subjects;
    public $subjectTypes;
    public $examNames;
    public $examTypes;
    public $examParts;
    public $examModes;
    public $grades;
    public $sessions;
    public $schools;
    public $users;
    public $existingMarksEntries;
    
    // Form data
    public $formData = [];
    public $editingId = null;
    public $isEditingEnabled = false;
    
    // Subject type filtering
    public $selectedSubjectTypeIds = [];  // Default to empty - all shown
    
    // Data caching to prevent reloading on every refresh
    private $cache = [];
    
    protected $listeners = ['refreshComponent' => '$refresh'];
    
    // Query time optimization properties
    protected $casts = [
        'selectedSubjectTypeIds' => 'array'
    ];
    
    public function mount()
    {
        $this->loadData();
        $this->initializeFormData();
    }
    
    public function loadData()
    {
        $this->classes = Myclass::orderBy('name')->get();
        $this->sections = MyclassSection::with(['section', 'myclass'])->orderBy('myclass_id')->get();
        $this->subjects = Subject::orderBy('name')->get();
        $this->subjectTypes = SubjectType::orderBy('name')->get();
        $this->examNames = Exam01Name::orderBy('name')->get();
        $this->examTypes = Exam02Type::orderBy('name')->get();
        $this->examParts = Exam03Part::orderBy('name')->get();
        $this->examModes = Exam04Mode::orderBy('name')->get();
        $this->grades = Exam08Grade::orderBy('name')->get();
        $this->sessions = Session::orderBy('name')->get();
        $this->schools = School::orderBy('name')->get();
        $this->users = User::orderBy('name')->get();
        
        // Load existing exam class subjects
        $this->examClassSubjects = MyclassSubject::with([
            'myclass', 
            'subject', 
            'subject.subjectType'
        ])->get();
        
        // Load existing marks entries
        $this->existingMarksEntries = Exam10MarksEntry::with([
            'examDetail.examName',
            'examDetail.examType',
            'examDetail.examPart',
            'examClassSubject',
            'myclassSection.section',
            'studentcr',
            'grade',
            'session'
        ])->get();
    }
    
    public function initializeFormData()
    {
        // Initialize form data structure and load existing records
        $existingRecords = Exam10MarksEntry::with([
            'examDetail', 
            'examClassSubject', 
            'myclassSection',
            'studentcr'
        ])->get();
        
        foreach ($existingRecords as $record) {
            $key = $record->myclass_section_id . '_' . $record->exam_detail_id . '_' . $record->studentcr_id;
            $this->formData[$key] = [
                'exam_marks' => $record->exam_marks,
                'grade_id' => $record->grade_id,
                'is_absent' => $record->is_absent,
                'session_id' => $record->session_id,
                'school_id' => $record->school_id,
                'user_id' => $record->user_id,
                'approved_by' => $record->approved_by,
                'is_active' => $record->is_active,
                'is_finalized' => $record->is_finalized,
                'status' => $record->status,
                'remarks' => $record->remarks
            ];
        }
    }
    
    public function setActiveTab($index)
    {
        $this->activeTab = $index;
    }
    
    public function getClassSections($classId)
    {
        // Check cache first
        $cacheKey = "class_sections_{$classId}";
        if (isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }
        
        $sections = MyclassSection::where('myclass_id', $classId)
            ->with(['section'])
            ->orderBy('section_id')
            ->get();
        
        // Cache the result
        $this->cache[$cacheKey] = $sections;
        
        return $sections;
    }
    
    public function getStudentsInSection($myclassSectionId)
    {
        // Check cache first
        $cacheKey = "students_section_{$myclassSectionId}";
        if (isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }
        
        // First get the MyclassSection record to get myclass_id and section_id
        $myclassSection = MyclassSection::find($myclassSectionId);
        
        if (!$myclassSection) {
            return collect();
        }
        
        // Query students using the separate myclass_id and section_id columns
        $students = Studentcr::where('myclass_id', $myclassSection->myclass_id)
            ->where('section_id', $myclassSection->section_id)
            ->with(['studentdb', 'myclass', 'section'])
            ->orderBy('roll_no')
            ->get();
        
        // Cache the result
        $this->cache[$cacheKey] = $students;
        
        return $students;
    }
    
    public function getClassSubjectsGroupedByType($classId)
    {
        $classSubjects = MyclassSubject::whereHas('myclass', function($query) use ($classId) {
            $query->where('id', $classId);
        })
        ->with(['subject.subjectType', 'myclass'])
        ->get();
        
        // Group by subject type
        $grouped = $classSubjects->groupBy(function ($item) {
            return $item->subject->subject_type_id;
        });
        
        return $grouped;
    }
    
    public function getExamDetailsForClass($classId)
    {
        return Exam05Detail::where('myclass_id', $classId)
            ->with(['examName', 'examType', 'examPart', 'examMode'])
            ->orderBy('exam_name_id')
            ->orderBy('exam_type_id')
            ->orderBy('exam_part_id')
            ->get()
            ->groupBy('exam_name_id');
    }
    
    public function getExamDetailsGroupedByExamName($classId)
    {
        return Exam05Detail::where('myclass_id', $classId)
            ->with(['examName', 'examType', 'examPart', 'examMode'])
            ->orderBy('exam_name_id')
            ->orderBy('exam_part_id')
            ->get()
            ->groupBy('exam_name_id');
    }
    
    public function getExamDetailsGroupedByExamNameAndPart($classId)
    {
        // Check cache first
        $cacheKey = "exam_details_{$classId}";
        if (isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }
        
        $examDetails = Exam05Detail::where('myclass_id', $classId)
            ->with(['examName', 'examType', 'examPart', 'examMode'])
            ->orderBy('exam_name_id')
            ->orderBy('exam_part_id')
            ->get();
        
        // Group by exam_name_id first, then by exam_part_id
        $grouped = [];
        foreach ($examDetails as $detail) {
            $examNameId = $detail->exam_name_id;
            $examPartId = $detail->exam_part_id;
            
            if (!isset($grouped[$examNameId])) {
                $grouped[$examNameId] = [];
            }
            
            if (!isset($grouped[$examNameId][$examPartId])) {
                $grouped[$examNameId][$examPartId] = [];
            }
            
            $grouped[$examNameId][$examPartId][] = $detail;
        }
        
        // Cache the result
        $this->cache[$cacheKey] = $grouped;
        
        return $grouped;
    }
    
    public function getExamDetailsForStudent($classId)
    {
        $examDetails = Exam05Detail::where('myclass_id', $classId)
            ->with(['examName', 'examType', 'examPart', 'examMode'])
            ->orderBy('exam_name_id')
            ->orderBy('exam_part_id')
            ->get()
            ->groupBy('exam_name_id');
        
        return $examDetails;
    }
    
    public function getExamClassSubjectsForClass($classId)
    {
        // Check cache first
        $cacheKey = "class_subjects_{$classId}";
        if (isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }
        
        $subjects = MyclassSubject::whereHas('myclass', function($query) use ($classId) {
            $query->where('id', $classId);
        })
        ->with(['subject.subjectType', 'myclass'])
        ->orderBy('subject_id')
        ->get();
        
        // Cache the result
        $this->cache[$cacheKey] = $subjects;
        
        return $subjects;
    }
    
    public function getExamClassSubjectsGroupedByType($classId)
    {
        // Check cache first
        $cacheKey = "subject_groups_{$classId}_" . md5(serialize($this->selectedSubjectTypeIds));
        if (isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }
        
        $classSubjects = $this->getExamClassSubjectsForClass($classId);
        
        // Apply subject type filter if any selected
        if (!empty($this->selectedSubjectTypeIds)) {
            $classSubjects = $classSubjects->filter(function ($item) {
                return in_array($item->subject->subject_type_id, $this->selectedSubjectTypeIds);
            });
        }
        
        // Group by subject type
        $grouped = $classSubjects->groupBy(function ($item) {
            return $item->subject->subject_type_id;
        });
        
        // Create a new collection with explicit ordering
        $sortedGrouped = collect();
        
        // Define the priority order: Summative (1) first, then Formative (2)
        $priorityOrder = [1, 2]; // 1 = Summative, 2 = Formative
        
        // Add subjects in priority order
        foreach ($priorityOrder as $priorityTypeId) {
            if ($grouped->has($priorityTypeId)) {
                $sortedGrouped[$priorityTypeId] = $grouped[$priorityTypeId];
            }
        }
        
        // Add any remaining subject types that aren't in the priority list
        foreach ($grouped as $subjectTypeId => $subjects) {
            if (!in_array($subjectTypeId, $priorityOrder)) {
                $sortedGrouped[$subjectTypeId] = $subjects;
            }
        }
        
        // Cache the result
        $this->cache[$cacheKey] = $sortedGrouped;
        
        return $sortedGrouped;
    }
    
    public function getExamClassSubjectsGroupedByExamType($classId)
    {
        $classSubjects = $this->getExamClassSubjectsForClass($classId);
        
        // Group by exam type
        $grouped = $classSubjects->groupBy(function ($item) {
            return $item->examDetail->exam_type_id;
        });
        
        // Sort by exam_type_id
        return $grouped->sortKeys();
    }
    
    public function getExamClassSubjectId($examDetailId, $myclassId, $subjectId)
    {
        // Find the exam_class_subject_id using Exam06ClassSubject model based on exam_detail_id, myclass_id, and subject_id
        $examClassSubject = Exam06ClassSubject::where('exam_detail_id', $examDetailId)
            ->where('myclass_id', $myclassId)
            ->where('subject_id', $subjectId)
            ->first();
            
        return $examClassSubject ? $examClassSubject->id : null;
    }
    
    public function getExamDetailAndClassSubjectId($classId, $subjectId, $examNameId, $examPartId, $details = null)
    {
        // If details array is provided (from Blade template), use it to find the exact exam detail
        if ($details && is_array($details)) {
            foreach ($details as $detail) {
                if ($detail->subject_id == $subjectId && $detail->exam_name_id == $examNameId && $detail->exam_part_id == $examPartId) {
                    // Found the exact exam detail, now get the exam class subject
                    $examClassSubject = Exam06ClassSubject::where('exam_detail_id', $detail->id)
                        ->where('myclass_id', $classId)
                        ->where('subject_id', $subjectId)
                        ->first();
                    
                    if ($examClassSubject) {
                        return [
                            'exam_detail_id' => $detail->id,
                            'exam_class_subject_id' => $examClassSubject->id
                        ];
                    }
                }
            }
        }
        
        // Fallback method: try to find the exam class subject ID using the relationship
        $examClassSubject = Exam06ClassSubject::where('myclass_id', $classId)
            ->where('subject_id', $subjectId)
            ->first();
            
        if (!$examClassSubject) {
            return ['exam_detail_id' => null, 'exam_class_subject_id' => null];
        }
        
        // Then get the exam detail ID from the exam class subject
        $examDetailId = $examClassSubject->exam_detail_id;
        
        // Verify that this exam detail matches our exam name and part
        $examDetail = Exam05Detail::find($examDetailId);
        if (!$examDetail || $examDetail->exam_name_id != $examNameId || $examDetail->exam_part_id != $examPartId) {
            return ['exam_detail_id' => null, 'exam_class_subject_id' => null];
        }
        
        return [
            'exam_detail_id' => $examDetailId,
            'exam_class_subject_id' => $examClassSubject->id
        ];
    }
    
    public function getStudentMarksData($myclassSectionId, $examNameId, $examPartId, $subjectGroups, $studentsInSection)
    {
        // Get the myclass_id from the section
        $myclassSection = MyclassSection::find($myclassSectionId);
        $myclassId = $myclassSection ? $myclassSection->myclass_id : null;
        
        if (!$myclassId) {
            return [];
        }
        
        // Pre-load all exam class subjects for this class and subjects
        $subjectIds = [];
        foreach ($subjectGroups as $subjectsOfType) {
            foreach ($subjectsOfType as $classSubject) {
                $subjectIds[] = $classSubject->subject_id;
            }
        }
        
        // Get all exam class subjects for this class and subjects
        $allExamClassSubjects = Exam06ClassSubject::where('myclass_id', $myclassId)
            ->whereIn('subject_id', $subjectIds)
            ->get();
        
        // Pre-load all exam details for this exam name and part
        // IMPORTANT: We need to consider that exam_type_id is also part of the unique combination
        // But for display purposes, we're showing all exam details for the given exam_name_id and exam_part_id
        $examDetails = Exam05Detail::where('myclass_id', $myclassId)
            ->where('exam_name_id', $examNameId)
            ->where('exam_part_id', $examPartId)
            ->get()
            ->keyBy('id');
        
        // Pre-load all marks entries for this section
        $studentIds = $studentsInSection->pluck('id')->toArray();
        $examDetailIds = $examDetails->pluck('id')->toArray();
        
        $marksEntries = Exam10MarksEntry::where('myclass_section_id', $myclassSectionId)
            ->whereIn('exam_detail_id', $examDetailIds)
            ->whereIn('studentcr_id', $studentIds)
            ->get()
            ->groupBy(['studentcr_id', 'exam_detail_id']);
        
        // Prepare the marks data array
        $marksData = [];
        
        foreach ($studentsInSection as $student) {
            $studentId = $student->id;
            $marksData[$studentId] = [];
            
            foreach ($subjectGroups as $subjectTypeId => $subjectsOfType) {
                foreach ($subjectsOfType as $classSubject) {
                    $subjectId = $classSubject->subject_id;
                    
                    // CORRECTED LOGIC:
                    // 1. Find all exam_class_subject records for this subject
                    $subjectEcsRecords = $allExamClassSubjects->filter(function ($ecs) use ($subjectId) {
                        return $ecs->subject_id == $subjectId;
                    });
                    
                    // 2. For each exam_class_subject, check if its exam_detail_id exists in our filtered exam details
                    $validEcsRecord = null;
                    $matchingExamDetailId = null;
                    
                    foreach ($subjectEcsRecords as $ecsRecord) {
                        if ($examDetails->has($ecsRecord->exam_detail_id)) {
                            $validEcsRecord = $ecsRecord;
                            $matchingExamDetailId = $ecsRecord->exam_detail_id;
                            break;
                        }
                    }
                    
                    if ($validEcsRecord && $matchingExamDetailId) {
                        // Get marks entry for this student with the matching exam detail
                        $studentEntries = $marksEntries->get($studentId);
                        $marksEntry = null;
                        if ($studentEntries && $studentEntries->get($matchingExamDetailId)) {
                            $marksEntry = $studentEntries->get($matchingExamDetailId)->first();
                        }
                        
                        if ($marksEntry) {
                            $marksData[$studentId][$subjectId] = [
                                'exam_marks' => $marksEntry->exam_marks,
                                'grade_id' => $marksEntry->grade_id,
                                'is_absent' => $marksEntry->is_absent,
                                'exam_class_subject_id' => $marksEntry->exam_class_subject_id,
                                'display_marks' => $marksEntry->isAbsent() ? 'AB' : $marksEntry->getDisplayMarks(),
                                'exam_detail_id' => $matchingExamDetailId
                            ];
                        } else {
                            $marksData[$studentId][$subjectId] = [
                                'exam_marks' => null,
                                'grade_id' => null,
                                'is_absent' => false,
                                'exam_class_subject_id' => $validEcsRecord->id,
                                'display_marks' => '-',
                                'exam_detail_id' => $matchingExamDetailId
                            ];
                        }
                    } else {
                        // No valid exam class subject found for this subject in current context
                        $marksData[$studentId][$subjectId] = [
                            'exam_marks' => null,
                            'grade_id' => null,
                            'is_absent' => false,
                            'exam_class_subject_id' => null,
                            'display_marks' => 'No ECS',
                            'exam_detail_id' => null
                        ];
                    }
                }
            }
        }
        
        return $marksData;
    }
    
    public function getMarksDataArray($myclassSectionId)
    {
        // Get all marks entries for the given myclass_section_id
        $marksEntries = Exam10MarksEntry::where('myclass_section_id', $myclassSectionId)
            ->with(['examDetail', 'studentcr'])
            ->get();
            
        $marksData = [];
        
        foreach ($marksEntries as $entry) {
            $studentcrId = $entry->studentcr_id;
            $examDetailId = $entry->exam_detail_id;
            $subjectId = $entry->examDetail->subject_id;
            
            // Initialize the array structure if it doesn't exist
            if (!isset($marksData[$studentcrId])) {
                $marksData[$studentcrId] = [];
            }
            
            if (!isset($marksData[$studentcrId][$examDetailId])) {
                $marksData[$studentcrId][$examDetailId] = [];
            }
            
            // Store the marks data
            $marksData[$studentcrId][$examDetailId][$subjectId] = [
                'exam_marks' => $entry->exam_marks,
                'grade_id' => $entry->grade_id,
                'is_absent' => $entry->is_absent,
                'session_id' => $entry->session_id,
                'school_id' => $entry->school_id,
                'user_id' => $entry->user_id,
                'approved_by' => $entry->approved_by,
                'is_active' => $entry->is_active,
                'is_finalized' => $entry->is_finalized,
                'status' => $entry->status,
                'remarks' => $entry->remarks,
                'exam_class_subject_id' => $entry->exam_class_subject_id,
                'created_at' => $entry->created_at,
                'updated_at' => $entry->updated_at
            ];
        }
        
        return $marksData;
    }
    
    public function debugMarksData($myclassSectionId)
    {
        $marksData = $this->getMarksDataArray($myclassSectionId);
        return [
            'section_id' => $myclassSectionId,
            'total_students' => count($marksData),
            'sample_data' => array_slice($marksData, 0, 1)
        ];
    }
    
    public function debugStudentMarksData($myclassSectionId, $examNameId, $examPartId, $subjectGroups, $studentsInSection)
    {
        $marksData = $this->getStudentMarksData($myclassSectionId, $examNameId, $examPartId, $subjectGroups, $studentsInSection);
        
        // Get some statistics
        $totalCells = 0;
        $filledCells = 0;
        $absentCells = 0;
        
        foreach ($marksData as $studentId => $subjects) {
            foreach ($subjects as $subjectId => $marks) {
                $totalCells++;
                if ($marks['exam_marks'] !== null) {
                    $filledCells++;
                }
                if (isset($marks['is_absent']) && $marks['is_absent']) {
                    $absentCells++;
                }
            }
        }
        
        return [
            'total_cells' => $totalCells,
            'filled_cells' => $filledCells,
            'absent_cells' => $absentCells,
            'fill_rate' => $totalCells > 0 ? round(($filledCells / $totalCells) * 100, 2) : 0,
            'sample_student_data' => array_slice($marksData, 0, 1)
        ];
    }
    
    // New debug method to verify exam_detail_id correctness
    public function debugExamDetailMatching($myclassSectionId, $examNameId, $examPartId)
    {
        $myclassSection = MyclassSection::find($myclassSectionId);
        $myclassId = $myclassSection ? $myclassSection->myclass_id : null;
        
        if (!$myclassId) {
            return ['error' => 'Invalid myclass_section_id'];
        }
        
        // Get exam details for this context
        $examDetails = Exam05Detail::where('myclass_id', $myclassId)
            ->where('exam_name_id', $examNameId)
            ->where('exam_part_id', $examPartId)
            ->with(['examName', 'examType', 'examPart'])
            ->get();
            
        // Get all exam class subjects for this class
        $allExamClassSubjects = Exam06ClassSubject::where('myclass_id', $myclassId)
            ->with(['subject'])
            ->get();
            
        $debugInfo = [
            'myclass_id' => $myclassId,
            'exam_name_id' => $examNameId,
            'exam_part_id' => $examPartId,
            'exam_details_count' => $examDetails->count(),
            'exam_class_subjects_count' => $allExamClassSubjects->count(),
            'exam_details' => [],
            'mapping_analysis' => []
        ];
        
        // Show exam details
        foreach ($examDetails as $detail) {
            $debugInfo['exam_details'][] = [
                'id' => $detail->id,
                'exam_name' => $detail->examName->name ?? 'N/A',
                'exam_type' => $detail->examType->name ?? 'N/A',
                'exam_part' => $detail->examPart->name ?? 'N/A'
            ];
        }
        
        // Analyze mapping
        foreach ($allExamClassSubjects as $ecs) {
            $examDetail = $examDetails->firstWhere('id', $ecs->exam_detail_id);
            $debugInfo['mapping_analysis'][] = [
                'exam_class_subject_id' => $ecs->id,
                'subject_name' => $ecs->subject->name ?? 'N/A',
                'linked_exam_detail_id' => $ecs->exam_detail_id,
                'exam_detail_exists' => $examDetail ? 'YES' : 'NO',
                'matched_context' => $examDetail ? 'YES' : 'NO'
            ];
        }
        
        return $debugInfo;
    }
    
    // Method to get data for cell debugging
    public function getCellDebugData($myclassSectionId, $examNameId, $examPartId)
    {
        $myclassSection = MyclassSection::find($myclassSectionId);
        $myclassId = $myclassSection ? $myclassSection->myclass_id : null;
        
        if (!$myclassId) {
            return ['allExamClassSubjects' => collect(), 'examDetails' => collect()];
        }
        
        $allExamClassSubjects = Exam06ClassSubject::where('myclass_id', $myclassId)->get();
        $examDetails = Exam05Detail::where('myclass_id', $myclassId)
            ->where('exam_name_id', $examNameId)
            ->where('exam_part_id', $examPartId)
            ->get();
            
        return [
            'allExamClassSubjects' => $allExamClassSubjects,
            'examDetails' => $examDetails
        ];
    }
    
    // Debug method to show detailed matching information
    public function debugDetailedMatching($myclassSectionId, $examNameId, $examPartId, $subjectGroups)
    {
        $myclassSection = MyclassSection::find($myclassSectionId);
        $myclassId = $myclassSection ? $myclassSection->myclass_id : null;
        
        if (!$myclassId) {
            return ['error' => 'Invalid myclass_section_id'];
        }
        
        // Get the data we're working with
        $subjectIds = [];
        foreach ($subjectGroups as $subjectsOfType) {
            foreach ($subjectsOfType as $classSubject) {
                $subjectIds[] = $classSubject->subject_id;
            }
        }
        
        $allExamClassSubjects = Exam06ClassSubject::where('myclass_id', $myclassId)
            ->whereIn('subject_id', $subjectIds)
            ->get();
            
        $examDetails = Exam05Detail::where('myclass_id', $myclassId)
            ->where('exam_name_id', $examNameId)
            ->where('exam_part_id', $examPartId)
            ->get()
            ->keyBy('id');
            
        $debugInfo = [
            'myclass_id' => $myclassId,
            'exam_name_id' => $examNameId,
            'exam_part_id' => $examPartId,
            'total_exam_details' => $examDetails->count(),
            'total_exam_class_subjects' => $allExamClassSubjects->count(),
            'exam_details_list' => [],
            'subject_matching' => []
        ];
        
        // List all exam details
        foreach ($examDetails as $detail) {
            $debugInfo['exam_details_list'][] = [
                'id' => $detail->id,
                'exam_type_id' => $detail->exam_type_id,
                'exam_name_id' => $detail->exam_name_id,
                'exam_part_id' => $detail->exam_part_id
            ];
        }
        
        // Check matching for each subject
        foreach ($subjectGroups as $subjectTypeId => $subjectsOfType) {
            foreach ($subjectsOfType as $classSubject) {
                $subjectId = $classSubject->subject_id;
                
                // Find all ECS records for this subject
                $subjectEcsRecords = $allExamClassSubjects->filter(function ($ecs) use ($subjectId) {
                    return $ecs->subject_id == $subjectId;
                });
                
                $validMatches = [];
                foreach ($subjectEcsRecords as $ecsRecord) {
                    $hasValidDetail = $examDetails->has($ecsRecord->exam_detail_id);
                    $validMatches[] = [
                        'ecs_id' => $ecsRecord->id,
                        'exam_detail_id' => $ecsRecord->exam_detail_id,
                        'valid_in_context' => $hasValidDetail,
                        'detail_exists' => Exam05Detail::find($ecsRecord->exam_detail_id) ? true : false
                    ];
                }
                
                $debugInfo['subject_matching'][] = [
                    'subject_id' => $subjectId,
                    'subject_name' => $classSubject->subject->name ?? 'Unknown',
                    'ecs_records_count' => $subjectEcsRecords->count(),
                    'valid_matches' => $validMatches
                ];
            }
        }
        
        return $debugInfo;
    }
    
    public function getExistingMarksEntry($myclassSectionId, $examDetailId, $studentcrId)
    {
        return Exam10MarksEntry::where('myclass_section_id', $myclassSectionId)
            ->where('exam_detail_id', $examDetailId)
            ->where('studentcr_id', $studentcrId)
            ->first();
    }
    
    public function verifyExamClassSubjectRelationship($myclassId, $subjectId, $examDetailId)
    {
        // Verify that there's an exam class subject linking these three entities
        $examClassSubject = Exam06ClassSubject::where('myclass_id', $myclassId)
            ->where('subject_id', $subjectId)
            ->where('exam_detail_id', $examDetailId)
            ->first();
            
        return $examClassSubject ? $examClassSubject->id : null;
    }
    
    public function debugExamClassSubjects($myclassId, $subjectIds)
    {
        $examClassSubjects = Exam06ClassSubject::where('myclass_id', $myclassId)
            ->whereIn('subject_id', $subjectIds)
            ->with(['examDetail.examName', 'examDetail.examType', 'examDetail.examPart', 'subject'])
            ->get();
            
        return $examClassSubjects->map(function ($ecs) {
            return [
                'id' => $ecs->id,
                'myclass_id' => $ecs->myclass_id,
                'subject_id' => $ecs->subject_id,
                'subject_name' => $ecs->subject->name ?? 'N/A',
                'exam_detail_id' => $ecs->exam_detail_id,
                'exam_name' => $ecs->examDetail->examName->name ?? 'N/A',
                'exam_type' => $ecs->examDetail->examType->name ?? 'N/A',
                'exam_part' => $ecs->examDetail->examPart->name ?? 'N/A'
            ];
        });
    }
    
    public function getFormDataValue($myclassSectionId, $examDetailId, $studentcrId, $field)
    {
        $key = $myclassSectionId . '_' . $examDetailId . '_' . $studentcrId;
        $record = $this->getExistingMarksEntry($myclassSectionId, $examDetailId, $studentcrId);
        
        if ($record && isset($this->formData[$key][$field])) {
            return $this->formData[$key][$field];
        } elseif ($record) {
            return $record->$field;
        } elseif (isset($this->formData[$key][$field])) {
            return $this->formData[$key][$field];
        }
        
        return '';
    }
    
    public function saveMarksEntry($myclassSectionId, $examDetailId, $studentcrId)
    {
        $key = $myclassSectionId . '_' . $examDetailId . '_' . $studentcrId;
        $data = $this->formData[$key] ?? [];
        
        // Validate required fields
        if (!isset($data['exam_marks']) && empty($data['is_absent'])) {
            session()->flash('error', 'Marks or absent status is required.');
            return;
        }
        
        $record = Exam10MarksEntry::updateOrCreate(
            [
                'myclass_section_id' => $myclassSectionId,
                'exam_detail_id' => $examDetailId,
                'studentcr_id' => $studentcrId
            ],
            [
                'exam_marks' => $data['exam_marks'] ?? null,
                'grade_id' => $data['grade_id'] ?? null,
                'is_absent' => $data['is_absent'] ?? false,
                'session_id' => $data['session_id'] ?? null,
                'school_id' => $data['school_id'] ?? null,
                'user_id' => $data['user_id'] ?? null,
                'approved_by' => $data['approved_by'] ?? null,
                'is_active' => $data['is_active'] ?? true,
                'is_finalized' => $data['is_finalized'] ?? false,
                'status' => $data['status'] ?? 'active',
                'remarks' => $data['remarks'] ?? ''
            ]
        );
        
        session()->flash('message', 'Marks entry saved successfully.');
        $this->emit('refreshComponent');
    }
    
    public function editMarksEntry($id)
    {
        $record = Exam10MarksEntry::findOrFail($id);
        $this->editingId = $id;
        
        $key = $record->myclass_section_id . '_' . $record->exam_detail_id . '_' . $record->studentcr_id;
        $this->formData[$key] = [
            'exam_marks' => $record->exam_marks,
            'grade_id' => $record->grade_id,
            'is_absent' => $record->is_absent,
            'session_id' => $record->session_id,
            'school_id' => $record->school_id,
            'user_id' => $record->user_id,
            'approved_by' => $record->approved_by,
            'is_active' => $record->is_active,
            'is_finalized' => $record->is_finalized,
            'status' => $record->status,
            'remarks' => $record->remarks
        ];
    }
    
    public function updateMarksEntry()
    {
        if (!$this->editingId) return;
        
        $record = Exam10MarksEntry::findOrFail($this->editingId);
        $key = $record->myclass_section_id . '_' . $record->exam_detail_id . '_' . $record->studentcr_id;
        $data = $this->formData[$key] ?? [];
        
        $record->update([
            'exam_marks' => $data['exam_marks'] ?? null,
            'grade_id' => $data['grade_id'] ?? null,
            'is_absent' => $data['is_absent'] ?? false,
            'session_id' => $data['session_id'] ?? null,
            'school_id' => $data['school_id'] ?? null,
            'user_id' => $data['user_id'] ?? null,
            'approved_by' => $data['approved_by'] ?? null,
            'is_active' => $data['is_active'] ?? true,
            'is_finalized' => $data['is_finalized'] ?? false,
            'status' => $data['status'] ?? 'active',
            'remarks' => $data['remarks'] ?? ''
        ]);
        
        $this->editingId = null;
        session()->flash('message', 'Marks entry updated successfully.');
        $this->emit('refreshComponent');
    }
    
    public function deleteMarksEntry($id)
    {
        Exam10MarksEntry::findOrFail($id)->delete();
        session()->flash('message', 'Marks entry deleted successfully.');
        $this->emit('refreshComponent');
    }
    
    public function cancelEdit()
    {
        $this->editingId = null;
    }
    
    public function toggleEditEnable()
    {
        $this->isEditingEnabled = !$this->isEditingEnabled;
    }
    
    public function render()
    {
        return view('livewire.exam12-exam-mark-register-comp', [
            'classes' => $this->classes,
            'sections' => $this->sections,
            'students' => $this->students,
            'examClassSubjects' => $this->examClassSubjects,
            'examDetails' => $this->examDetails,
            'subjects' => $this->subjects,
            'subjectTypes' => $this->subjectTypes,
            'examNames' => $this->examNames,
            'examTypes' => $this->examTypes,
            'examParts' => $this->examParts,
            'examModes' => $this->examModes,
            'grades' => $this->grades,
            'sessions' => $this->sessions,
            'schools' => $this->schools,
            'users' => $this->users
        ]);
    }
    
    // Clear cache when subject type filter changes
    public function updatedSelectedSubjectTypeIds()
    {
        $this->cache = [];
        $this->emit('refreshComponent');
    }
    
    // Toggle all subject types
    public function toggleAllSubjectTypes()
    {
        if (count($this->selectedSubjectTypeIds) == $this->subjectTypes->count()) {
            $this->selectedSubjectTypeIds = [];
        } else {
            $this->selectedSubjectTypeIds = $this->subjectTypes->pluck('id')->toArray();
        }
        $this->updatedSelectedSubjectTypeIds();
    }
}
