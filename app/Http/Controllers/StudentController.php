<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\LectureAvailability;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    //
    public function studentAppointment()
    {
        // Fetch available lecturers and their available times
        $availabilities = LectureAvailability::with('lecturer') // Assuming LectureAvailability has a relationship to Lecturer
            ->where('status', 'available') // Assuming availability has a status field
            ->get();

        $student = Student::where('user_id', Auth::user()->id)->first();

        return view('students.appointment.index', compact('availabilities', 'student'));
    }

    public function bookAppointment(Request $request)
    {
        $request->validate([
            'availability_id' => 'required|exists:lecture_availabilities,id',
            'appointment_date' => 'required|date|after_or_equal:today',
        ]);

        $availabilityId = $request->input('availability_id');

        // Check if the availability exists
        $availability = LectureAvailability::find($availabilityId);

        if (!$availability) {
            return redirect()->back()->with('error', 'The selected availability does not exist.');
        }

        // Create the appointment
        $appointment = new Appointment();
        $appointment->student_id = $request->input('student_id');
        $appointment->lecturer_id = $request->input('lecturer_id');
        $appointment->availability_id = $availability->id;
        $appointment->appointment_date = $request->input('appointment_date');
        $appointment->status = 'pending';
        $appointment->save();

        return redirect()->route('student.appointments.index')->with('success', 'Appointment booked successfully.');
    }
}
