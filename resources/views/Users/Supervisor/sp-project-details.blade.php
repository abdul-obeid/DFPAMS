@extends('templates.main-page-template')

@section('content')
<div class="container text-start">
    <h1 class="display-5">Project: {{ $project->title }}</h1>
    <p><strong>Specialization:</strong> {{ $project->specialization }}</p>
    <p><strong>Group Project:</strong> {{ $project->is_group_project ? 'Yes' : 'No' }}</p>

    <h2>Student(s):</h2>
    <ul>
        @foreach($project->students as $student)
        <li>{{ $student->user->name }} ({{ $student->user->email }})</li>
        @endforeach
    </ul>

    <h2>Meeting Log Submissions:</h2>
    <div class="row">
        @for ($i = 1; $i <= 6; $i++)
            @php
                $submitted = $project->meetingLogs->contains('log_num', $i);
                $status = $submitted ? 'Submitted' : 'Pending';
            @endphp
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 {{ $submitted ? 'submitted' : 'pending' }}">
                    <div class="card-body">
                        <h4 class="card-title">Meeting Log {{ $i }}</h4>
                        <p>Status: {{ $status }}</p>
                        <a href="#" class="btn btn-info">View Details</a>
                    </div>
                </div>
            </div>
        @endfor
    </div>
    <br>
    <hr>
    <br>
    <h2>Deliverables Status</h2>
    <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 report">
                <div class="card-body">
                    <h4 class="card-title">Final Report</h4>
                    <p>Status: Pending</p>
                    <a href="#" class="btn btn-info">View Details</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 demo">
                <div class="card-body">
                    <h4 class="card-title">Demo Video</h4>
                    <p>Status: Pending</p>
                    <a href="#" class="btn btn-info">View Details</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 poster">
                <div class="card-body">
                    <h4 class="card-title">Poster</h4>
                    <p>Status: Pending</p>
                    <a href="#" class="btn btn-info">View Details</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection