@extends('layouts.app')
@section('title', 'Lectures Available')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Lectures
                    <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#addLectureModal">
                        Add New Lecture
                    </button>
                </div>
                <div class="card-body">
                    <table id="dataTables" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Lecture Number</th>
                                <th scope="col">Names</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Department</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lectures as $lecture)
                            <tr>
                                <th scope="row">{{ $lecture->id }}</th>
                                <td>{{ $lecture->lecture_number }}</td>
                                <td>{{ $lecture->names }}</td>
                                <td>{{ $lecture->user->email }}</td>
                                <td>{{ $lecture->phone ? $lecture->user->phone : 'No Phone added' }}</td>
                                <td>
                                    {{ $lecture->department ? $lecture->department->name : 'No Department Assigned' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection