<!-- resources/views/admin/appointments/index.blade.php -->
@extends('layouts.app')

@section('title', 'Appointments | Admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Appointments</h2>

    <!-- Appointments Table -->
    <div class="card shadow-sm">
        <div class="card-header">
            <h5>All Appointments</h5>
        </div>
        <div class="card-body">
            <!-- Appointments Table -->
            <table id="dataTables" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Lecturer Name</th>
                        <th>Appointment Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $appointment->student->name }}</td>
                        <td>{{ $appointment->lecturer->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($appointment->date)->format('d M, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</td>
                        <td>{{ $appointment->status }}</td>
                        <td>
                            <!-- Action buttons (e.g., edit, delete) -->
                            <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection