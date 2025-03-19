@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Available Appointments</h2>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <table id="dataTables" class="table table-striped">
            <thead>
                <tr>
                    <th>Lecturer</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($availabilities as $availability)
                <tr>
                    <td>{{ $availability->lecturer->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($availability->date)->format('l, F j, Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($availability->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($availability->end_time)->format('g:i A') }}</td>
                    <td>
                        <span class="badge 
                        {{ $availability->status == 'available' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($availability->status) }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#bookAppointmentModal{{ $availability->id }}">
                            Book Appointment
                        </button>
                    </td>
                </tr>

                <!-- Book Appointment Modal -->
                <div class="modal fade" id="bookAppointmentModal{{ $availability->id }}" tabindex="-1" aria-labelledby="bookAppointmentModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="bookAppointmentModalLabel">Book Appointment with {{ $availability->lecturer->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('student.appointments.book') }}">
                                    @csrf
                                    <input type="hidden" name="availability_id" value="{{ $availability->id }}">
                                    <input type="hidden" name="lecturer_id" value="{{ $availability->lecturer->id }}">
                                    <div class="mb-3">
                                        <label for="appointment_date" class="form-label">Appointment Date</label>
                                        <input type="date" class="form-control" id="appointment_date" name="appointment_date" required min="{{ now()->format('Y-m-d') }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Book Appointment</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection