<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Lecture;
use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $lecturersCount = Lecture::count();
        $studentsCount = Student::count();
        $appointmentsCount = Appointment::count();
        $departmentsCount = Department::count();

        // Get recent 5 appointments and lecturers
        $recentAppointments = Appointment::latest()->take(5)->get();
        $recentLecturers = Lecture::latest()->take(5)->get();

        return view('admin.dashboard.index', compact(
            'lecturersCount',
            'studentsCount',
            'appointmentsCount',
            'departmentsCount',
            'recentAppointments',
            'recentLecturers'
        ));
    }
}
