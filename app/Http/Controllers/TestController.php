<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function userDashboard()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        
        $user = Auth::user();
        
        // Return user info and the view
        return response()->json([
            'user_id' => $user->id,
            'name' => $user->name,
            'role_id' => $user->role_id,
            'studentdb_id' => $user->studentdb_id,
            'should_see_verification' => ($user->role_id == 0 && $user->studentdb_id == 0)
        ]);
    }
    
    public function testUserDashboardView()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        return view('user-dashboard');
    }
}