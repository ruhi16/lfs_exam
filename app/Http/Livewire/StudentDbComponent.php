<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Studentdb;
use App\Models\Myclass;
use App\Models\Section;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudentDbComponent extends Component
{
    use WithFileUploads, WithPagination;

    // Form properties
    public $showModal = false;
    public $currentStep = 1;
    public $totalSteps = 4;
    public $editMode = false;
    public $studentId = null;

    // Step 1: Basic Information
    public $studentid, $name, $fname, $mname, $dob, $ssex, $blood_grp;
    public $adhaar, $fadhaar, $madhaar;

    // Step 2: Address & Contact
    public $vill1, $vill2, $post, $pstn, $dist, $pin, $state;
    public $mobl1, $mobl2;

    // Step 3: Academic & Personal Details
    public $admBookNo, $admSlNo, $admDate, $prCls, $prSch;
    public $phch, $relg, $cste, $natn;
    public $stclass_id, $stsection_id;

    // Step 4: Bank Details & Documents
    public $accNo, $ifsc, $micr, $bnnm, $brnm;
    public $img_ref_profile, $img_ref_brthcrt, $img_ref_adhaar;
    public $profile_image, $birth_certificate, $aadhar_card;

    // Other properties
    public $remarks, $crstatus = 'active';

    // Display properties
    public $selectedClass = '';
    public $selectedSection = '';
    public $searchTerm = '';
    public $showDebugPanel = false;
    public $debugInfo = [];

    protected $rules = [
        // Step 1
        'name' => 'required|string|max:255',
        'fname' => 'nullable|string|max:255',
        'mname' => 'nullable|string|max:255',
        'dob' => 'nullable|date',
        'ssex' => 'nullable|in:Male,Female,Other',
        'blood_grp' => 'nullable|string|max:10',
        'adhaar' => 'nullable|string|max:12',
        'fadhaar' => 'nullable|string|max:12',
        'madhaar' => 'nullable|string|max:12',

        // Step 2
        'vill1' => 'nullable|string|max:255',
        'vill2' => 'nullable|string|max:255',
        'post' => 'nullable|string|max:255',
        'pstn' => 'nullable|string|max:255',
        'dist' => 'nullable|string|max:255',
        'pin' => 'nullable|string|max:10',
        'state' => 'nullable|string|max:255',
        'mobl1' => 'nullable|string|max:15',
        'mobl2' => 'nullable|string|max:15',

        // Step 3
        'admBookNo' => 'nullable|integer',
        'admSlNo' => 'nullable|integer',
        'admDate' => 'nullable|date',
        'prCls' => 'nullable|string|max:255',
        'prSch' => 'nullable|string|max:255',
        'phch' => 'nullable|string|max:255',
        'relg' => 'nullable|string|max:255',
        'cste' => 'nullable|string|max:255',
        'natn' => 'nullable|string|max:255',
        'stclass_id' => 'nullable|exists:myclasses,id',
        'stsection_id' => 'nullable|exists:sections,id',

        // Step 4
        'accNo' => 'nullable|string|max:255',
        'ifsc' => 'nullable|string|max:11',
        'micr' => 'nullable|string|max:9',
        'bnnm' => 'nullable|string|max:255',
        'brnm' => 'nullable|string|max:255',
        'profile_image' => 'nullable|image|max:2048',
        'birth_certificate' => 'nullable|image|max:2048',
        'aadhar_card' => 'nullable|image|max:2048',
    ];

    public function mount()
    {
        $this->generateStudentId();
        $this->updateDebugInfo();
    }

    public function generateStudentId()
    {
        $this->studentid = 'STU' . date('Y') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
        $this->currentStep = 1;
        $this->editMode = false;
        $this->generateStudentId();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'studentid',
            'name',
            'fname',
            'mname',
            'dob',
            'ssex',
            'blood_grp',
            'adhaar',
            'fadhaar',
            'madhaar',
            'vill1',
            'vill2',
            'post',
            'pstn',
            'dist',
            'pin',
            'state',
            'mobl1',
            'mobl2',
            'admBookNo',
            'admSlNo',
            'admDate',
            'prCls',
            'prSch',
            'phch',
            'relg',
            'cste',
            'natn',
            'stclass_id',
            'stsection_id',
            'accNo',
            'ifsc',
            'micr',
            'bnnm',
            'brnm',
            'profile_image',
            'birth_certificate',
            'aadhar_card',
            'remarks'
        ]);
        $this->currentStep = 1;
        $this->studentId = null;
    }

    public function nextStep()
    {
        $this->validateCurrentStep();

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
        $this->updateDebugInfo();
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
        $this->updateDebugInfo();
    }

    public function validateCurrentStep()
    {
        $stepRules = $this->getStepRules($this->currentStep);
        $this->validate($stepRules);
    }

    private function getStepRules($step)
    {
        $allRules = $this->rules;

        switch ($step) {
            case 1:
                return array_intersect_key($allRules, array_flip([
                    'name',
                    'fname',
                    'mname',
                    'dob',
                    'ssex',
                    'blood_grp',
                    'adhaar',
                    'fadhaar',
                    'madhaar'
                ]));
            case 2:
                return array_intersect_key($allRules, array_flip([
                    'vill1',
                    'vill2',
                    'post',
                    'pstn',
                    'dist',
                    'pin',
                    'state',
                    'mobl1',
                    'mobl2'
                ]));
            case 3:
                return array_intersect_key($allRules, array_flip([
                    'admBookNo',
                    'admSlNo',
                    'admDate',
                    'prCls',
                    'prSch',
                    'phch',
                    'relg',
                    'cste',
                    'natn',
                    'stclass_id',
                    'stsection_id'
                ]));
            case 4:
                return array_intersect_key($allRules, array_flip([
                    'accNo',
                    'ifsc',
                    'micr',
                    'bnnm',
                    'brnm',
                    'profile_image',
                    'birth_certificate',
                    'aadhar_card'
                ]));
            default:
                return [];
        }
    }

    public function save()
    {
        $this->validate();

        try {
            $data = [
                'studentid' => $this->studentid,
                'uuid_auto' => Str::uuid(),
                'name' => $this->name,
                'fname' => $this->fname,
                'mname' => $this->mname,
                'dob' => $this->dob,
                'ssex' => $this->ssex,
                'blood_grp' => $this->blood_grp,
                'adhaar' => $this->adhaar,
                'fadhaar' => $this->fadhaar,
                'madhaar' => $this->madhaar,
                'vill1' => $this->vill1,
                'vill2' => $this->vill2,
                'post' => $this->post,
                'pstn' => $this->pstn,
                'dist' => $this->dist,
                'pin' => $this->pin,
                'state' => $this->state,
                'mobl1' => $this->mobl1,
                'mobl2' => $this->mobl2,
                'admBookNo' => $this->admBookNo,
                'admSlNo' => $this->admSlNo,
                'admDate' => $this->admDate,
                'prCls' => $this->prCls,
                'prSch' => $this->prSch,
                'phch' => $this->phch,
                'relg' => $this->relg,
                'cste' => $this->cste,
                'natn' => $this->natn,
                'stclass_id' => $this->stclass_id,
                'stsection_id' => $this->stsection_id,
                'accNo' => $this->accNo,
                'ifsc' => $this->ifsc,
                'micr' => $this->micr,
                'bnnm' => $this->bnnm,
                'brnm' => $this->brnm,
                'crstatus' => $this->crstatus,
                'remarks' => $this->remarks,
                'user_id' => auth()->id() ?? 1,
                'session_id' => 1,
                'school_id' => 1,
            ];

            // Handle file uploads
            if ($this->profile_image) {
                $data['img_ref_profile'] = $this->profile_image->store('student-profiles', 'public');
            }
            if ($this->birth_certificate) {
                $data['img_ref_brthcrt'] = $this->birth_certificate->store('student-documents', 'public');
            }
            if ($this->aadhar_card) {
                $data['img_ref_adhaar'] = $this->aadhar_card->store('student-documents', 'public');
            }

            if ($this->editMode && $this->studentId) {
                $student = Studentdb::findOrFail($this->studentId);
                $student->update($data);
                session()->flash('message', 'Student updated successfully!');
            } else {
                Studentdb::create($data);
                session()->flash('message', 'Student created successfully!');
            }

            $this->closeModal();
            $this->updateDebugInfo();
        } catch (\Exception $e) {
            session()->flash('error', 'Error saving student: ' . $e->getMessage());
            $this->updateDebugInfo(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $student = Studentdb::findOrFail($id);

        $this->studentId = $student->id;
        $this->editMode = true;

        // Populate form fields
        $this->studentid = $student->studentid;
        $this->name = $student->name;
        $this->fname = $student->fname;
        $this->mname = $student->mname;
        $this->dob = $student->dob;
        $this->ssex = $student->ssex;
        $this->blood_grp = $student->blood_grp;
        $this->adhaar = $student->adhaar;
        $this->fadhaar = $student->fadhaar;
        $this->madhaar = $student->madhaar;
        $this->vill1 = $student->vill1;
        $this->vill2 = $student->vill2;
        $this->post = $student->post;
        $this->pstn = $student->pstn;
        $this->dist = $student->dist;
        $this->pin = $student->pin;
        $this->state = $student->state;
        $this->mobl1 = $student->mobl1;
        $this->mobl2 = $student->mobl2;
        $this->admBookNo = $student->admBookNo;
        $this->admSlNo = $student->admSlNo;
        $this->admDate = $student->admDate;
        $this->prCls = $student->prCls;
        $this->prSch = $student->prSch;
        $this->phch = $student->phch;
        $this->relg = $student->relg;
        $this->cste = $student->cste;
        $this->natn = $student->natn;
        $this->stclass_id = $student->stclass_id;
        $this->stsection_id = $student->stsection_id;
        $this->accNo = $student->accNo;
        $this->ifsc = $student->ifsc;
        $this->micr = $student->micr;
        $this->bnnm = $student->bnnm;
        $this->brnm = $student->brnm;
        $this->img_ref_profile = $student->img_ref_profile;
        $this->img_ref_brthcrt = $student->img_ref_brthcrt;
        $this->img_ref_adhaar = $student->img_ref_adhaar;
        $this->crstatus = $student->crstatus;
        $this->remarks = $student->remarks;

        $this->showModal = true;
        $this->currentStep = 1;
    }

    public function delete($id)
    {
        try {
            $student = Studentdb::findOrFail($id);

            // Delete associated files
            if ($student->img_ref_profile) {
                Storage::disk('public')->delete($student->img_ref_profile);
            }
            if ($student->img_ref_brthcrt) {
                Storage::disk('public')->delete($student->img_ref_brthcrt);
            }
            if ($student->img_ref_adhaar) {
                Storage::disk('public')->delete($student->img_ref_adhaar);
            }

            $student->delete();
            session()->flash('message', 'Student deleted successfully!');
            $this->updateDebugInfo();
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting student: ' . $e->getMessage());
        }
    }

    public function toggleDebugPanel()
    {
        $this->showDebugPanel = !$this->showDebugPanel;
        $this->updateDebugInfo();
    }

    public function testImagePath($studentId)
    {
        $student = Studentdb::find($studentId);
        if ($student && $student->img_ref_profile) {
            $imagePath = $student->img_ref_profile;
            $fullPath = storage_path('app/public/' . $imagePath);
            $publicPath = public_path('storage/' . $imagePath);
            $assetUrl = asset('storage/' . $imagePath);

            $this->updateDebugInfo([
                'test_student_id' => $studentId,
                'image_path' => $imagePath,
                'full_storage_path' => $fullPath,
                'public_path' => $publicPath,
                'asset_url' => $assetUrl,
                'file_exists_storage' => file_exists($fullPath),
                'file_exists_public' => file_exists($publicPath),
            ]);
        }
    }

    private function updateDebugInfo($additional = [])
    {
        // Check storage setup
        $storageInfo = [
            'storage_link_exists' => is_link(public_path('storage')),
            'storage_path' => storage_path('app/public'),
            'public_storage_path' => public_path('storage'),
            'profiles_dir_exists' => is_dir(storage_path('app/public/student-profiles')),
            'documents_dir_exists' => is_dir(storage_path('app/public/student-documents')),
        ];

        $this->debugInfo = array_merge([
            'current_step' => $this->currentStep,
            'total_records' => Studentdb::count(),
            'filtered_records' => $this->getFilteredStudents()->count(),
            'selected_class' => $this->selectedClass,
            'selected_section' => $this->selectedSection,
            'search_term' => $this->searchTerm,
            'form_mode' => $this->editMode ? 'Edit' : 'Create',
            'timestamp' => now()->format('Y-m-d H:i:s'),
        ], $storageInfo, $additional);
    }

    private function getFilteredStudents()
    {
        $query = Studentdb::with(['myclass', 'sections']);

        if ($this->selectedClass) {
            $query->where('stclass_id', $this->selectedClass);
        }

        if ($this->selectedSection) {
            $query->where('stsection_id', $this->selectedSection);
        }

        if ($this->searchTerm) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('studentid', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('fname', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('adhaar', 'like', '%' . $this->searchTerm . '%');
            });
        }

        return $query;
    }

    public function updatedSelectedClass()
    {
        $this->selectedSection = '';
        $this->resetPage();
        $this->updateDebugInfo();
    }

    public function updatedSelectedSection()
    {
        $this->resetPage();
        $this->updateDebugInfo();
    }

    public function updatedSearchTerm()
    {
        $this->resetPage();
        $this->updateDebugInfo();
    }

    public function render()
    {
        $students = $this->getFilteredStudents()->paginate(12);
        $classes = Myclass::orderBy('order_index')->get();
        $sections = Section::orderBy('order_index')->get();

        // Group students by class - use items() to get the actual collection
        $studentsByClass = collect($students->items())->groupBy(function ($student) {
            // Additional safety check
            if (!$student || !is_object($student)) {
                return 'Invalid Student';
            }
            return $student->myclass ? $student->myclass->name : 'No Class';
        });

        $this->updateDebugInfo([
            'current_page_count' => $students->total(),
            'classes_count' => $classes->count(),
            'sections_count' => $sections->count(),
        ]);

        return view('livewire.student-db-component', [
            'students' => $students,
            'studentsByClass' => $studentsByClass,
            'classes' => $classes,
            'sections' => $sections,
        ]);
    }
}
