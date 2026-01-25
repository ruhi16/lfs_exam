<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Studentcr;
use App\Models\Studentdb;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function dashboard()
    {
        return view('user-dashboard');
    }
    
    public function requestToBeTeacher(Request $request)
    {
        $user = Auth::user();
        
        if ($user && $user->role_id == 0 && $user->studentdb_id == 0) {
            $userModel = User::find($user->id);
            $userModel->is_requested = true;
            $userModel->save();
            
            return redirect()->back()->with('message', 'Your request to become a teacher has been submitted successfully!');
        }
        
        return redirect()->back()->with('error', 'You are not eligible to make this request.');
    }
    
    public function cancelTeacherRequest(Request $request)
    {
        $user = Auth::user();
        
        if ($user && $user->role_id == 0 && $user->studentdb_id == 0 && $user->is_requested == 1) {
            $userModel = User::find($user->id);
            $userModel->is_requested = false;
            $userModel->save();
            
            return redirect()->back()->with('message', 'Your teacher request has been cancelled successfully!');
        }
        
        return redirect()->back()->with('error', 'You are not eligible to cancel this request.');
    }
    
    public function verifyStudent(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:myclasses,id',
            'section_id' => 'required|exists:sections,id',
            'roll_no' => 'required|string|max:20',
            'dob' => 'required|date',
        ]);
        
        try {
            // Find the student based on provided details
            $student = Studentcr::where('myclass_id', $request->class_id)
                              ->where('section_id', $request->section_id)
                              ->where('roll_no', $request->roll_no)
                              ->first();
            
            // Check if student exists and DOB matches
            if ($student && $student->studentdb->dob == $request->dob) {
                $user = Auth::user();
                $userModel = User::find($user->id);
                
                // Update user with role_id = 1 (User role) and studentdb_id
                $userModel->role_id = 1; // Predefined as User role
                $userModel->studentdb_id = $student->studentdb->id; // Set to the studentdb_id of the student
                $userModel->teacher_id = null; // Set teacher_id to null for students
                $userModel->save();
                
                // Update the studentdb record with the user_id
                $studentdb = Studentdb::find($student->studentdb->id);
                if ($studentdb) {
                    $studentdb->user_id = $user->id; // Set to the current user_id
                    $studentdb->save();
                }
                
                return redirect()->back()->with('message', 'Student verification successful! Your account has been upgraded to student role.');
            } else {
                return redirect()->back()->with('error', 'No student found with the provided details. Please check and try again.');
            }
        } catch (\Exception $e) {
            Log::error('Error verifying student: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred during verification. Please try again.');
        }
    }
    
    public function fetchStudentDetails(Request $request): JsonResponse
    {
        $request->validate([
            'class_id' => 'required|exists:myclasses,id',
            'section_id' => 'required|exists:sections,id',
            'roll_no' => 'required|string|max:20',
        ]);
        
        try {
            // Find the student based on provided details
            $student = Studentcr::where('myclass_id', $request->class_id)
                              ->where('section_id', $request->section_id)
                              ->where('roll_no', $request->roll_no)
                              ->first();
            
            if ($student) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'name' => $student->studentdb->name ?? '',
                        'father_name' => $student->studentdb->fname ?? '',
                        'address' => ($student->studentdb->vill1 ?? '') . ', ' . ($student->studentdb->post ?? '') . ', ' . ($student->studentdb->pstn ?? ''),
                        'class' => $student->myclass->name ?? '',
                        'section' => $student->section->name ?? '',
                        'roll_no' => $student->roll_no,
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No student found with the provided details.'
                ], 404);
            }
        } catch (\Exception $e) {
            Log::error('Error fetching student details: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching student details.'
            ], 500);
        }
    }
    
    public function verifyStudentDob(Request $request): JsonResponse
    {
        $request->validate([
            'class_id' => 'required|exists:myclasses,id',
            'section_id' => 'required|exists:sections,id',
            'roll_no' => 'required|string|max:20',
            'dob' => 'required|date',
        ]);
        
        try {
            // Find the student based on provided details
            $student = Studentcr::where('myclass_id', $request->class_id)
                              ->where('section_id', $request->section_id)
                              ->where('roll_no', $request->roll_no)
                              ->first();
            
            // Check if student exists and DOB matches
            if ($student && $student->studentdb->dob == $request->dob) {
                return response()->json([
                    'success' => true,
                    'message' => 'Date of birth verified successfully!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Date of birth does not match our records. Please check and try again.'
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('Error verifying student DOB: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during verification.'
            ], 500);
        }
    }
}
