<div>
    <div class="h-fit min-w-full mx-auto py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex flex-row items-center justify-between">
                    <div>You're logged in! as <span class="text-blue-500 font-bold">{{ auth()->user()->name ?? 'Not
                            Found' }}</span></div>
                    <div class="flex flex-row gap-4">
                        @if(auth()->user()->role_id == 0 && auth()->user()->studentdb_id == 0)
                        <div>
                            <button wire:click='openStudentModal'
                                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center">
                                <i class="fas fa-user-graduate mr-2"></i>Student Verification
                            </button>
                        </div>
                        @elseif(auth()->user()->role_id == 1)
                        <div class="text-green-600 font-bold flex items-center">
                            <i class="fas fa-user-graduate mr-2"></i>Student Role Assigned
                        </div>
                        @endif

                        @if(auth()->user()->role_id == 0 && auth()->user()->studentdb_id == 0)
                        <!-- Not yet a Student -->
                        <div>
                            @if(auth()->user()->is_requested == 0 || auth()->user()->is_requested == null)
                            <button wire:click='requestToBeTeacher'
                                class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded flex items-center">
                                <i class="fas fa-chalkboard-teacher mr-2"></i>Request to be a Teacher
                            </button>
                            @else
                            <div class="text-red-600 font-bold flex items-center">
                                <i class="fas fa-clock mr-2"></i>Request Pending!!!
                            </div>
                            @endif
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        {{-- {{ auth()->user()->studentdb->id }} --}}


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

        @if (session()->has('student_verified'))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
                <div class="flex">
                    <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                    {{ session('student_verified') }}
                </div>
            </div>
        </div>
        @endif

        @if (session()->has('student_error'))
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
                <div class="flex">
                    <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                    {{ session('student_error') }}
                </div>
            </div>
        </div>
        @endif

        <!-- Student Verification Modal -->
        @if($showStudentModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center pb-3 border-b">
                        <h3 class="text-lg font-semibold text-gray-900">Verify Student Identity</h3>
                        <button wire:click="closeStudentModal" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="pt-4">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                <div>
                                    <h4 class="text-sm font-medium text-blue-900">Student Role Assignment</h4>
                                    <p class="text-sm text-blue-700 mt-1">To assign a student role, please verify
                                        the student's details below.</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Class Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Class *</label>
                                <select wire:model="selectedClass"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                                @error('selectedClass')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Section Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Section *</label>
                                <select wire:model="selectedSection"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Section</option>
                                    @foreach($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                                    @endforeach
                                </select>
                                @error('selectedSection')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Roll Number -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Roll Number *</label>
                                <input type="text" wire:model="studentRoll" placeholder="Enter roll number"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('studentRoll')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth *</label>
                                <input type="date" wire:model="studentDob"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('studentDob')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <button wire:click="verifyStudent" type="button"
                                class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                <i class="fas fa-search mr-2"></i>Verify Student Details
                            </button>
                        </div>

                        @if(session()->has('student_verified'))
                        <div class="mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
                            <div class="flex">
                                <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                                {{ session('student_verified') }}
                            </div>
                        </div>

                        <div class="mt-4">
                            <button wire:click="assignStudentRole" type="button"
                                class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-user-graduate mr-2"></i>Assign Student Role
                            </button>
                        </div>
                        @endif

                        @if(session()->has('student_error'))
                        <div class="mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
                            <div class="flex">
                                <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                                {{ session('student_error') }}
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-3 pt-4 border-t">
                        <button wire:click="closeStudentModal" type="button"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(auth()->user()->role_id == 0 && auth()->user()->studentdb_id == 0)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mt-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <h3 class="text-lg font-semibold text-yellow-800">Account Verification Required</h3>
                    <p class="text-yellow-600">Please verify your identity to access all features</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <button wire:click='openStudentModal'
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md font-medium transition-colors flex items-center justify-center">
                        <i class="fas fa-user-graduate mr-2"></i>Student Verification
                    </button>
                    @if(auth()->user()->is_requested == 0 || auth()->user()->is_requested == null)
                    <button wire:click='requestToBeTeacher'
                        class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-md font-medium transition-colors flex items-center justify-center">
                        <i class="fas fa-chalkboard-teacher mr-2"></i>Request to be a Teacher
                    </button>
                    @else
                    <div
                        class="px-4 py-2 bg-red-100 text-red-800 rounded-md font-medium flex items-center justify-center">
                        <i class="fas fa-clock mr-2"></i>Teacher Request Pending
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Student Profile Display -->
        @if(auth()->user()->role_id == 1 && auth()->user()->studentdb)
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Student Profile</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-gray-600">Name: <span class="font-medium">{{ auth()->user()->name }}</span>
                            </p>
                            <p class="text-gray-600">Email: <span class="font-medium">{{ auth()->user()->email }}</span>
                            </p>
                            <p class="text-gray-600">Class: <span class="font-medium">{{
                                    auth()->user()->studentdb->myclass->name ?? 'N/A' }}</span></p>
                            <p class="text-gray-600">Section: <span class="font-medium">{{
                                    auth()->user()->studentdb->sections->name ?? 'N/A' }}</span></p>
                        </div>
                        <div>
                            <p class="text-gray-600">Roll Number: <span class="font-medium">{{
                                    auth()->user()->studentdb->studentcrs->first()->roll_no ?? 'N/A' }}</span></p>
                            <p class="text-gray-600">Date of Birth: <span class="font-medium">{{
                                    auth()->user()->studentdb->dob ?? 'N/A' }}</span></p>
                            <p class="text-gray-600">Student ID: <span class="font-medium">{{
                                    auth()->user()->studentdb->id }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>