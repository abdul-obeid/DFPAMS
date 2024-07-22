@extends('templates.main-page-template')

@section('content')
<div class="container text-start">
    <h1 class="display-5">{{ ucfirst($submissionType) }} Submission for Project: {{ $project->title }}</h1>
    
    <div class="card">
        <div class="card-body">
            @if ($submission)
                <p>Document: <a href="{{ route('submissions.download', $submission->id) }}">{{ $submission->doc_name }}</a></p>
                
                <form action="{{ route('submissions.feedback', $submission->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="feedback">Feedback:</label>
                        <textarea name="feedback" id="feedback" class="form-control" style = 'border: 1px solid grey'>{{ $submission->feedback }}</textarea>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Submit Feedback</button>
                </form>
            @else
                <p>No {{ ucfirst($submissionType) }} submission has been made yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection