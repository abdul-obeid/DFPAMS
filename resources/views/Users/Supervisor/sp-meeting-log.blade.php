@extends('templates.main-page-template')

@section('content')
<div class="container">
    <h1>Meeting Log Details</h1>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Meeting Log #{{ $meetingLog->log_num }}</h5>
            <p class="card-text">Submitted on: {{ $meetingLog->created_at->format('d M Y, h:i A') }}</p>

            <a href="{{ route('supervisor-meeting-log.download', ['projId' => $project->id, 'logNum' => $meetingLog->log_num]) }}" class="btn btn-primary">Download Meeting Log</a>
        </div>
    </div>

    <form action="{{ route('supervisor-meeting-log.feedback', ['projId' => $project->id, 'logNum' => $meetingLog->log_num]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="feedback">Feedback</label>
            <textarea name="feedback" id="feedback" rows="5" class="form-control" style="border: 1px solid grey;">{{ old('feedback', $meetingLog->supervisor_feedback) }}</textarea>
        </div>
        <button type="submit" class="btn btn-success mt-3">Submit Feedback</button>
    </form>
</div>
@endsection