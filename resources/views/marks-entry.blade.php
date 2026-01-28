@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Marks Entry</h1>

            @if(isset($exam_detail_id) && isset($myclass_section_id) && isset($myclass_subject_id))
                <!-- Individual Marks Entry Component -->
                <div class="mb-8">
                    @if(request()->has('teacher_id'))
                        <livewire:exam10-exam-marks-entry-indv2-comp :exam_class_subject_id="$myclass_subject_id"
                            :exam_detail_id="$exam_detail_id" :myclass_section_id="$myclass_section_id"
                            :myclass_subject_id="$myclass_subject_id" :teacher_id="request()->get('teacher_id')" />
                    @else
                        <livewire:exam10-exam-marks-entry-indv-comp :exam_detail_id="$exam_detail_id"
                            :myclass_section_id="$myclass_section_id" :myclass_subject_id="$myclass_subject_id" />
                    @endif
                </div>
            @else
                <!-- General Teacher Marks Entry Component -->
                <div class="mb-8">
                    <livewire:exam15-teacher-marks-entry-comp />
                </div>

                <!-- Additional marks entry components can be added here -->
                <div class="mt-8">
                    <livewire:exam10-exam-marks-entry-comp />
                </div>
            @endif
        </div>
    </div>
@endsection