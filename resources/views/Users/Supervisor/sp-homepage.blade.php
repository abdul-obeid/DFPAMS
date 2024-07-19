@extends('templates.main-page-template')

@section('content')
<div class="container">
    <h1 class="my-4">Supervisor Homepage</h1>
    <div class="row">
        @foreach($projects as $project)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="card-title">{{ $project->title }}</h4>
                    <p class="card-text"><strong>Cohort:</strong> {{ $project->cohort->trimester_code }}</p>
                    <p class="card-text"><strong>Specialization:</strong> {{ $project->specialization }}</p>
                    <p class="card-text"><strong>Group Project:</strong> {{ $project->is_group_project ? 'Yes' : 'No' }}</p>
                    <p class="card-text"><strong>Students:</strong></p>
                    <ul>
                        @foreach($project->students as $student)
                        <li>{{ $student->user->name }} ({{ $student->specialization }})</li>
                        @endforeach
                    </ul>
                    <a href="{{ route('project-details.index', $project->id) }}" class="btn btn-info">View Details</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
