@extends('templates.main-page-template')

@section('content')
<style>
    .timeline {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 50px 0;
    }
    .timeline-box {
        text-align: center;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        width: 120px;
    }
    .report-box {
        text-align: center;
        padding: 20px;
        border: 2px solid #613419;
        border-radius: 8px;
        width: 120px;
    }
    .demo-box {
        text-align: center;
        padding: 20px;
        border: 2px solid #6253e4;
        border-radius: 8px;
        width: 120px;
    }
    .poster-box {
        text-align: center;
        padding: 20px;
        border: 2px solid #f16262;
        border-radius: 8px;
        width: 120px;
    }
    .completed {
        background-color: #d4edda;
        border-color: #c3e6cb;
    }
    .pending {
        background-color: #fff3cd;
        border-color: #ffeeba;
    }
</style>
<div class="container">
    <h1 class="my-4 display-5">Student Submissions Timeline</h1>

    <h2 class='display-6'>Meeting logs submitted: 0/6</h2>

    <br>
    <br>

    <div class="row">
        @for ($i = 0; $i < 6; $i++)
            <div class="col-md-2">
                <div class="timeline-box pending"> {{--{{ $submission->status == 'completed' ? 'completed' : 'pending' }}--}}
                    <h4>Meeting {{ $i + 1 }}</h4>
                    <p>Status: Pending</p>
                    <a href="" class="btn btn-info">View Details</a>
                </div>
            </div>
        @endfor
    </div>
</div>

<br>
<br>
<div class='container'>
    <div class="row">
        <div class="col-md-4">
            <div class="report-box pending"> {{--{{ $submission->status == 'completed' ? 'completed' : 'pending' }}--}}
                <h4>Final Report</h4>
                <p>Status: Pending</p>
                <a href="" class="btn btn-info">View Details</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="timeline-box pending"> {{--{{ $submission->status == 'completed' ? 'completed' : 'pending' }}--}}
                <h4>Demo Video</h4>
                <p>Status: Pending</p>
                <a href="" class="btn btn-info">View Details</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="timeline-box pending"> {{--{{ $submission->status == 'completed' ? 'completed' : 'pending' }}--}}
                <h4>Poster</h4>
                <p>Status: Pending</p>
                <a href="" class="btn btn-info">View Details</a>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection