@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Students</h2>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @foreach ($students as $student)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $student->name }}</h5>
                        <p class="card-text">Available Slots:</p>

                        @if ($student->availabilities->isEmpty())
                            <p>No available slots</p>
                        @else
                            <ul>
                                @foreach ($student->availabilities as $availability)
                                    <li>
                                        Date: {{ $availability->date }} | 
                                        Time: {{ $availability->start_time }} - {{ $availability->end_time }} 
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookModal{{ $student->id }}-{{ $availability->id }}">
                                            Book Appointment
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            @foreach ($student->availabilities as $availability)
                <!-- Modal -->
                <div class="modal fade" id="bookModal{{ $student->id }}-{{ $availability->id }}" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="bookModalLabel">Book Appointment with {{ $student->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST" action="{{ route('lecturer.book', $student->id) }}">
                                @csrf
                                <input type="hidden" name="availability_id" value="{{ $availability->id }}">
                                <div class="modal-body">
                                    <p>Date: {{ $availability->date }}</p>
                                    <p>Time: {{ $availability->start_time }} - {{ $availability->end_time }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Book Appointment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

        @endforeach
    </div>
</div>
@endsection
