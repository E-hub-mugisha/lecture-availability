<!-- resources/views/lecturer/appointments/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Appointments</h2>
    
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Time</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $appointment->student->name }}</td>
                    <td>{{ $appointment->availability->start_time }}</td>
                    <td>{{ $appointment->availability->date }}</td>
                    <td>{{ $appointment->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
