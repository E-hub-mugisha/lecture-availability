<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Lecture;
use App\Models\LectureAvailability;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LectureController extends Controller
{
    //
    public function index()
    {
        $lectures = Lecture::all();
        $departments = Department::all();
        return view('admin.lectures.index', compact('lectures', 'departments'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'names' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        // Create the user first
        $user = User::create([
            'name' => $request->names,
            'email' => $request->email,
            'phone' => $request->phone,
            'email_verified_at' => now(),
            'address' => $request->address,
            'password' => Hash::make($request['password']),
            'type' => 2, // 2 for lecturer
        ]);

        // Create the lecturer record
        Lecture::create([
            'names' => $request->names,
            'user_id' => $user->id,
            'staff_number' => 'LEC' . str_pad($user->id, 6, '0', STR_PAD_LEFT), // Generate staff number
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('admin.lecturers.index')->with('success', 'Lecture added successfully.');
    }
    public function availableLecture()
    {
        $lectures = LectureAvailability::where('status', 'available')->get();
        return view('admin.lectures.available', compact('lectures'));
    }
    public function appointments()
    {
        $appointments = Appointment::all();
        return view('admin.lectures.appointments', compact('appointments'));
    }
    public function showLecture($id)
    {
        $departments = Department::all();
        $lecture = Lecture::findOrFail($id);
        return view('admin.lectures.profile', compact('lecture', 'departments'));
    }
    public function updateDepartment(Request $request, $id)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id'
        ]);

        $lecture = Lecture::where('id', $id)->first();

        if (!$lecture) {
            return redirect()->route('admin.lecturers.profile')->with('error', 'Lecture not found');
        }

        $lecture->department_id = $request->department_id;
        $lecture->save();

        return redirect()->back()->with('success', 'Department assigned successfully');
    }
    public function updateLecture(Request $request, $id)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        // Find the lecture and ensure it exists
        $lecture = Lecture::find($id);

        if (!$lecture) {
            return redirect()->back()->with('error', 'Lecture not found.');
        }

        // Find the associated user
        $user = User::find($lecture->user_id);

        if (!$user) {
            return redirect()->back()->with('error', 'Associated user not found.');
        }

        // Update user details
        $user->update([
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return redirect()->back()->with('success', 'Lecture info updated successfully');
    }
}
