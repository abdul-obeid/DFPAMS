@extends('templates.main-page-template')

@section('content')
<div class="container mt-5">
    <div>
        <div class="card-header">
            <h2 class="text-start display-4">Submit Meeting Log #{{$logNum}}</h2>
        </div>
            <form action="{{ route('student-meeting-logs.store', $logNum) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->id }}">
                <div class="form-group text-start">
                    <label for="document">Upload Document:</label>
                    <input type="file" class="form-control-file" id="document" name="document" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

@endsection