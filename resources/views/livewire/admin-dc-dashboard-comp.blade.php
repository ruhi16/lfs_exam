<div class="p-6 bg-gray-100">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- School and Session Info Card -->
        <div class="bg-blue-500 text-white rounded-lg shadow-md p-6 lg:col-span-2">
            <h3 class="text-2xl font-bold">{{ $school->name ?? 'School Name not set' }}</h3>
            <p class="text-lg mt-2">Current Session: {{ $session->name ?? 'Session not set' }}</p>
        </div>

        <!-- Total Classes Card -->
        <div class="bg-green-500 text-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold">Total Classes</h3>
            <p class="text-3xl font-extrabold mt-2">{{ $total_classes }}</p>
        </div>

        <!-- Total Sections Card -->
        <div class="bg-yellow-500 text-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold">Total Sections</h3>
            <p class="text-3xl font-extrabold mt-2">{{ $total_sections }}</p>
        </div>

        <!-- Total Students Card -->
        <div class="bg-purple-500 text-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold">Total Students</h3>
            <p class="text-3xl font-extrabold mt-2">{{ $total_students }}</p>
        </div>

        <!-- Total Teachers Card -->
        <div class="bg-red-500 text-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold">Total Teachers</h3>
            <p class="text-3xl font-extrabold mt-2">{{ $total_teachers }}</p>
        </div>

        <!-- Total Users Card -->
        <div class="bg-pink-500 text-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold">Total Users</h3>
            <p class="text-3xl font-extrabold mt-2">{{ $total_users }}</p>
        </div>

        <!-- Total Subjects Card -->
        <div class="bg-teal-500 text-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold">Total Subjects</h3>
            <p class="text-3xl font-extrabold mt-2">{{ $total_subjects }}</p>
        </div>
        
        <!-- Total Exams Card -->
        <div class="bg-indigo-500 text-white rounded-lg shadow-md p-6 lg:col-span-4">
            <h3 class="text-2xl font-bold text-center">Total Exams Configured</h3>
            <p class="text-5xl font-extrabold mt-2 text-center">{{ $total_exams }}</p>
        </div>
    </div>

    <!-- Tabular Information -->
    <div class="mt-8">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Detailed Information</h2>

        <!-- Exams Table -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">Exams Details (Grouped by Class)</h3>
            @forelse ($exams_by_class as $className => $exams)
                <div x-data="{ open: false }" class="mb-2 border rounded-md">
                    <div @click="open = !open" class="cursor-pointer bg-gray-100 p-3 rounded-t-md flex justify-between items-center">
                        <h4 class="text-lg font-semibold text-gray-800">{{ $className ?: 'Unassigned Class' }}</h4>
                        <span x-show="!open" class="text-gray-500">&plus;</span>
                        <span x-show="open" class="text-gray-500">&minus;</span>
                    </div>
                    <div x-show="open" class="p-2">
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                        <th class="py-2 px-4 text-left">Exam</th>
                                        <th class="py-2 px-4 text-left">Distribution</th>
                                        <th class="py-2 px-4 text-left">Marks Entry</th>
                                        <th class="py-2 px-4 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                    @forelse ($exams as $exam)
                                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                                            <td class="py-2 px-4 text-left">
                                                <div class="font-medium">{{ $exam->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $exam->examName->name ?? 'N/A' }}</div>
                                                <div class="text-xs text-blue-500">
                                                    {{ $exam->examType->name ?? 'N/A' }} |
                                                    {{ $exam->examPart->name ?? 'N/A' }} |
                                                    {{ $exam->examMode->name ?? 'N/A' }}
                                                </div>
                                            </td>
                                            <td class="py-2 px-4 text-left">
                                                <span class="bg-purple-200 text-purple-800 py-1 px-2 rounded-full text-xs">
                                                    {{ count($exam->ansscr_dists) }} distributed
                                                </span>
                                            </td>
                                            <td class="py-2 px-4 text-left">
                                                <span class="bg-orange-200 text-orange-800 py-1 px-2 rounded-full text-xs">
                                                    {{ count($exam->marks_entries) }} entries
                                                </span>
                                            </td>
                                            <td class="py-2 px-4 text-center">
                                                @if($exam->is_finalized)
                                                    <span class="bg-green-200 text-green-800 py-1 px-2 rounded-full text-xs">Finalized</span>
                                                @else
                                                    <span class="bg-yellow-200 text-yellow-800 py-1 px-2 rounded-full text-xs">Not Finalized</span>
                                                @endif
                                                @if($exam->is_active)
                                                    <span class="bg-blue-200 text-blue-800 py-1 px-2 rounded-full text-xs mt-1 inline-block">Active</span>
                                                @else
                                                    <span class="bg-gray-200 text-gray-800 py-1 px-2 rounded-full text-xs mt-1 inline-block">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center py-4">No exams found for this class.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center py-4">No exams found.</p>
            @endforelse
        </div>

        <!-- Classes and Sections Table -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">Classes and Sections</h3>
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Class Name</th>
                            <th class="py-3 px-6 text-left">Sections</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @forelse ($classes_with_sections as $class)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left">{{ $class->name }}</td>
                                <td class="py-3 px-6 text-left">
                                    @forelse ($class->myclass_sections as $myclass_section)
                                        <span class="bg-blue-200 text-blue-800 py-1 px-3 rounded-full text-xs mr-1">{{ $myclass_section->section->name }}</span>
                                    @empty
                                        No sections assigned.
                                    @endforelse
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="text-center py-4">No classes found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Subjects Table -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <h3 class="text-xl font-bold mb-4 text-gray-700">Subjects</h3>
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Subject Name</th>
                            <th class="py-3 px-6 text-left">Code</th>
                            <th class="py-3 px-6 text-left">Type</th>
                            <th class="py-3 px-6 text-left">Teachers</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @forelse ($subjects_with_details as $subject)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left">{{ $subject->name }}</td>
                                <td class="py-3 px-6 text-left">{{ $subject->code ?? 'N/A' }}</td>
                                <td class="py-3 px-6 text-left">{{ $subject->subjectType->name ?? 'N/A' }}</td>
                                <td class="py-3 px-6 text-left">
                                    @forelse ($subject->teachers as $teacher)
                                        <span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-xs mr-1">{{ $teacher->name }}</span>
                                    @empty
                                        No teachers assigned.
                                    @endforelse
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-4">No subjects found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Teachers Table -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <h3 class="text-xl font-bold mb-4 text-gray-700">Teachers</h3>
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Name</th>
                            <th class="py-3 px-6 text-left">Designation</th>
                            <th class="py-3 px-6 text-left">Main Subject</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @forelse ($teachers_with_details as $teacher)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left">{{ $teacher->name }}</td>
                                <td class="py-3 px-6 text-left">{{ $teacher->desig ?? 'N/A' }}</td>
                                <td class="py-3 px-6 text-left">{{ $teacher->subject->name ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center py-4">No teachers found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>