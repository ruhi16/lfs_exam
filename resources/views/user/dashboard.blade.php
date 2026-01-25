@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-8 sm:px-10 sm:py-10">
            <div class="flex flex-col md:flex-row items-center">
                <div class="flex-shrink-0 mb-6 md:mb-0 md:mr-8">
                    <div
                        class="bg-gray-200 border-2 border-dashed rounded-xl w-32 h-32 flex items-center justify-center">
                        <i class="fas fa-user-graduate text-gray-500 text-4xl"></i>
                    </div>
                </div>
                <div class="text-center md:text-left text-white">
                    <h1 class="text-3xl font-bold">Welcome, {{ Auth::user()->name }}!</h1>
                    <p class="mt-2 text-blue-100">
                        <i class="fas fa-id-card mr-2"></i>
                        Student Dashboard
                    </p>
                    <p class="mt-1 text-blue-100">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Today is {{ date('d M, Y') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
                <div class="flex">
                    <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                    {{ session('message') }}
                </div>
            </div>
        </div>
        @endif

        @if (session()->has('error'))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
                <div class="flex">
                    <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                    {{ session('error') }}
                </div>
            </div>
        </div>
        @endif

        <!-- Verification Section -->
        @if(Auth::user()->role_id == 0 && Auth::user()->studentdb_id == 0)
        <div class="p-6 sm:p-8 bg-yellow-50 border-b border-yellow-200">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <h3 class="text-lg font-semibold text-yellow-800">Account Verification Required</h3>
                    <p class="text-yellow-600">Please verify your identity to access all features</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <!-- Student Verification Button -->
                    <button onclick="openStudentVerificationModal()"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md font-medium transition-colors">
                        <i class="fas fa-user-graduate mr-2"></i>Student Verification
                    </button>

                    <!-- Teacher Request Button -->
                    <form method="POST" action="{{ route('user.request.teacher') }}">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-md font-medium transition-colors">
                            <i class="fas fa-chalkboard-teacher mr-2"></i>Request to be a Teacher
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        <!-- Main Content -->
        <div class="p-6 sm:p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Profile Card -->
                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-user-graduate text-xl"></i>
                        </div>
                        <h3 class="ml-4 text-lg font-semibold text-gray-900">My Profile</h3>
                    </div>
                    <p class="mt-4 text-gray-600">
                        View and manage your personal and academic information.
                    </p>
                    <a href="{{ route('user.profile') }}"
                        class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        View Profile
                        <i class="fas fa-arrow-right ml-2 text-sm"></i>
                    </a>
                </div>

                <!-- Exams Card -->
                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-clipboard-check text-xl"></i>
                        </div>
                        <h3 class="ml-4 text-lg font-semibold text-gray-900">My Exams</h3>
                    </div>
                    <p class="mt-4 text-gray-600">
                        Check your upcoming exams, results, and schedules.
                    </p>
                    <button
                        class="mt-4 inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                        View Exams
                        <i class="fas fa-arrow-right ml-2 text-sm"></i>
                    </button>
                </div>

                <!-- Attendance Card -->
                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-calendar-check text-xl"></i>
                        </div>
                        <h3 class="ml-4 text-lg font-semibold text-gray-900">Attendance</h3>
                    </div>
                    <p class="mt-4 text-gray-600">
                        Track your attendance records and statistics.
                    </p>
                    <button
                        class="mt-4 inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors">
                        View Attendance
                        <i class="fas fa-arrow-right ml-2 text-sm"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Profile Section (shown after verification) - Full Width -->
    @if(Auth::user()->role_id == 1 && Auth::user()->studentdb_id)
    <div class="mt-8">
        <h3 class="text-xl font-semibold text-gray-900 mb-4 px-4">Student Profile</h3>
        @livewire('student-profile-component')
    </div>
    @endif
</div>

<!-- Student Verification Modal -->
@if(Auth::user()->role_id == 0 && Auth::user()->studentdb_id == 0)
<div id="studentVerificationModal"
    class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-3 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Student Verification</h3>
                <button onclick="closeStudentVerificationModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="pt-4">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        <div>
                            <h4 class="text-sm font-medium text-blue-900">Verify Your Student Identity</h4>
                            <p class="text-sm text-blue-700 mt-1">Please provide your class, section, and roll number to
                                find your details, then verify with your date of birth.</p>
                        </div>
                    </div>
                </div>

                <form id="studentVerificationForm" method="POST" action="{{ route('user.verify.student') }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Class Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Class *</label>
                            <select name="class_id" id="class_id" onchange="clearVerificationResult()"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Class</option>
                                @foreach(App\Models\Myclass::where('is_active', true)->orderBy('name')->get() as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Section Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Section *</label>
                            <select name="section_id" id="section_id" onchange="clearVerificationResult()"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Section</option>
                                @foreach(App\Models\Section::orderBy('name')->get() as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Roll Number -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Roll Number *</label>
                            <input type="text" name="roll_no" id="roll_no" placeholder="Enter roll number"
                                onchange="clearVerificationResult()"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <!-- Find Student Button -->
                    <div class="mt-4">
                        <button type="button" onclick="findStudentDetails()"
                            class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Find Student
                        </button>
                    </div>

                    <!-- Student Details Section -->
                    <div id="studentDetailsSection" class="mt-4 hidden">
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <h4 class="text-md font-semibold text-gray-900 mb-2">Student Details</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <p class="text-sm text-gray-600">Name: <span id="studentName"
                                            class="font-medium"></span></p>
                                    <p class="text-sm text-gray-600">Father's Name: <span id="fatherName"
                                            class="font-medium"></span></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Address: <span id="studentAddress"
                                            class="font-medium"></span></p>
                                    <p class="text-sm text-gray-600">Class: <span id="studentClass"
                                            class="font-medium"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Date of Birth Verification -->
                    <div id="dobVerificationSection" class="mt-4 hidden">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <h4 class="text-md font-semibold text-yellow-900 mb-2">Verify Date of Birth</h4>
                            <p class="text-sm text-yellow-700 mb-3">Please enter your date of birth to verify your
                                identity</p>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth *</label>
                                <input type="date" name="dob" id="dob"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="mt-3">
                                <button type="button" onclick="verifyStudentDob()"
                                    class="w-full px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                                    Verify DOB
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Verification Result -->
                    <div id="verificationResult" class="mt-4 hidden">
                        <div id="verificationSuccess"
                            class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md hidden">
                            <div class="flex">
                                <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                                <span id="successMessage"></span>
                            </div>
                        </div>
                        <div id="verificationError"
                            class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md hidden">
                            <div class="flex">
                                <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                                <span id="errorMessage"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Confirm Button -->
                    <div id="confirmButtonSection" class="mt-6 hidden">
                        <button type="submit"
                            class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-user-graduate mr-2"></i>Confirm and Assign Student Role
                        </button>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end space-x-3 pt-4 border-t">
                <button onclick="closeStudentVerificationModal()" type="button"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endif

<script>
    function openStudentVerificationModal() {
        document.getElementById('studentVerificationModal').classList.remove('hidden');
    }
    
    function closeStudentVerificationModal() {
        document.getElementById('studentVerificationModal').classList.add('hidden');
        // Reset all form elements
        document.getElementById('class_id').value = '';
        document.getElementById('section_id').value = '';
        document.getElementById('roll_no').value = '';
        document.getElementById('dob').value = '';
        // Hide all sections
        document.getElementById('studentDetailsSection').classList.add('hidden');
        document.getElementById('dobVerificationSection').classList.add('hidden');
        document.getElementById('verificationResult').classList.add('hidden');
        document.getElementById('confirmButtonSection').classList.add('hidden');
        document.getElementById('verificationSuccess').classList.add('hidden');
        document.getElementById('verificationError').classList.add('hidden');
    }
    
    function clearVerificationResult() {
        // Hide verification result when any input changes
        document.getElementById('verificationResult').classList.add('hidden');
        document.getElementById('verificationSuccess').classList.add('hidden');
        document.getElementById('verificationError').classList.add('hidden');
        document.getElementById('confirmButtonSection').classList.add('hidden');
        document.getElementById('studentDetailsSection').classList.add('hidden');
        document.getElementById('dobVerificationSection').classList.add('hidden');
    }
    
    function findStudentDetails() {
        const classId = document.getElementById('class_id').value;
        const sectionId = document.getElementById('section_id').value;
        const rollNo = document.getElementById('roll_no').value;
        
        // Reset previous messages
        document.getElementById('verificationResult').classList.add('hidden');
        document.getElementById('verificationSuccess').classList.add('hidden');
        document.getElementById('verificationError').classList.add('hidden');
        document.getElementById('confirmButtonSection').classList.add('hidden');
        document.getElementById('studentDetailsSection').classList.add('hidden');
        document.getElementById('dobVerificationSection').classList.add('hidden');
        
        // Validate inputs
        if (!classId || !sectionId || !rollNo) {
            showError('Please fill in all required fields (Class, Section, and Roll Number).');
            return;
        }
        
        // Make AJAX request to fetch student details
        fetch('{{ route('user.fetch.student.details') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                class_id: classId,
                section_id: sectionId,
                roll_no: rollNo
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Populate student details
                document.getElementById('studentName').textContent = data.data.name;
                document.getElementById('fatherName').textContent = data.data.father_name;
                document.getElementById('studentAddress').textContent = data.data.address;
                document.getElementById('studentClass').textContent = data.data.class;
                
                // Show student details section
                document.getElementById('studentDetailsSection').classList.remove('hidden');
                document.getElementById('dobVerificationSection').classList.remove('hidden');
            } else {
                showError(data.message || 'Failed to fetch student details.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('An error occurred while fetching student details.');
        });
    }
    
    function verifyStudentDob() {
        const classId = document.getElementById('class_id').value;
        const sectionId = document.getElementById('section_id').value;
        const rollNo = document.getElementById('roll_no').value;
        const dob = document.getElementById('dob').value;
        
        // Reset previous messages
        document.getElementById('verificationResult').classList.add('hidden');
        document.getElementById('verificationSuccess').classList.add('hidden');
        document.getElementById('verificationError').classList.add('hidden');
        document.getElementById('confirmButtonSection').classList.add('hidden');
        
        // Validate DOB
        if (!dob) {
            showError('Please enter your date of birth.');
            return;
        }
        
        // Make AJAX request to verify DOB
        fetch('{{ route('user.verify.student.dob') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                class_id: classId,
                section_id: sectionId,
                roll_no: rollNo,
                dob: dob
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccess(data.message || 'Date of birth verified successfully!');
                document.getElementById('confirmButtonSection').classList.remove('hidden');
            } else {
                showError(data.message || 'Date of birth verification failed.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('An error occurred during verification.');
        });
    }
    
    function showSuccess(message) {
        document.getElementById('successMessage').textContent = message;
        document.getElementById('verificationResult').classList.remove('hidden');
        document.getElementById('verificationSuccess').classList.remove('hidden');
    }
    
    function showError(message) {
        document.getElementById('errorMessage').textContent = message;
        document.getElementById('verificationResult').classList.remove('hidden');
        document.getElementById('verificationError').classList.remove('hidden');
    }
</script>
@endsection