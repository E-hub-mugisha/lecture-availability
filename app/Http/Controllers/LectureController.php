<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Lecture;
use App\Models\LectureAvailability;
use App\Models\Student;
use App\Models\StudentAvailability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LectureController extends Controller
{
    public function index()
    {
        $lecturers = Lecture::where('user_id', Auth::id())->first();
        $availabilities = LectureAvailability::where('lecturer_id', $lecturers->id )->get();
        return view('lecturer.availability.index', compact('availabilities'));
    }

    public function appointment()
    {
        $lecturers = Lecture::where('user_id', Auth::id())->first();
        $appointments = Appointment::where('lecturer_id', $lecturers->id)->get();
        return view('lecturer.appointments.index', compact('appointments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today', // Ensures the date is today or in the future
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday', // Valid days of the week
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'status' => 'required | in:available,unavailable,break,lunch,meeting,training',
            'lecturer_id' => 'required',
        ]);

        LectureAvailability::create([
            'lecturer_id' => $request->lecturer_id,
            'day' => $request->day,
            'date' => $request->date,
            'status' => $request->status,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('lecturer.availability.index')->with('success', 'Availability added successfully!');
    }
    public function destroy($id)
    {
        $availability = LectureAvailability::findOrFail($id);


        // Delete the availability
        $availability->delete();

        return redirect()->route('lecturer.availability.index')->with('success', 'Availability deleted successfully.');
    }

    public function students()
    {
        // Fetch all students with their availabilities
        $students = Student::with('availabilities')->get();
        return view('lecturer.students.index', compact('students'));
    }
    // Lecturer books an appointment
    public function bookAppointment(Request $request, $studentId)
    {
        $request->validate([
            'availability_id' => 'required|exists:student_availabilities,id',
        ]);

        // Fetch the availability slot
        $availability = StudentAvailability::findOrFail($request->availability_id);

        // Check if the slot is still available
        if ($availability->status == 'booked') {
            return back()->withErrors('This slot is already booked.');
        }

        // Create an appointment
        Appointment::create([
            'student_id' => $studentId,
            'lecture_id' => auth()->user()->id,
            'availability_id' => $availability->id,
            'date' => $availability->date,
            'time' => $availability->start_time,
            'status' => 'pending',
        ]);

        // Update the availability status to 'booked'
        $availability->status = 'booked';
        $availability->save();

        return redirect()->route('students.index')->with('success', 'Appointment booked successfully!');
    }
    public function show()
    {
        $lecture = Lecture::where('user_id', Auth::id())->first(); // Assuming user has one lecture profile
        $departments = Department::all();

        return view('lecturer.profile.index', compact('lecture', 'departments'));
    }
    public function updateLecture(Request $request)
    {
        $request->validate([
            'staff_number' => 'required|string|max:255',
            'names' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]);

        $lecture = Auth::user()->lecture;

        $lecture->update([
            'staff_number' => $request->staff_number,
            'names' => $request->names,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('lecturer.profile')->with('success', 'Profile updated successfully!');
    }
}
