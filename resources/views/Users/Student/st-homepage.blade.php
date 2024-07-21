@extends('templates.main-page-template')

@section('content')
<link rel="stylesheet" href="{{ asset('css/student-homepage.css') }}">

<div class="container my-4">
    <div class="row">
        <!-- Timeline Column -->
        <div class="col-md-8">
            <h1 class="my-4 display-5">Student Submissions Timeline</h1>
            <h2 class='display-6'>Meeting logs submitted: 0/6</h2>

            <div class="wrapper">
                <div class="center-line">
                    <a href="#" class="scroll-icon"><i class="fas fa-caret-up"></i></a>
                </div>

                @for ($i = 1; $i <= 6; $i++)
                <div class="row row-{{ ($i % 2 == 1) ? '1' : '2' }}">
                    <section>
                        <i class="icon fas fa-home"></i>
                        <div class="details">
                            <span class="title">Meeting Log {{$i}}</span>
                            <br>
                            <span>Due: 1st Jan 2021</span>
                        </div>
                        <p>Status: Pending</p>
                        <p>Feedback: Lorem ipsum</p>
                        <div class="bottom">
                            <a href="{{ route('student-meeting-logs.index', $i) }}">View details</a>
                        </div>
                    </section>
                </div>
                @endfor

                <div class="row row-1">
                    <section>
                        <i class="icon fas fa-star"></i>
                        <div class="details">
                            <span class="title">Report submission</span>
                            <span>2nd Jan 2021</span>
                            <p>Status: Pending</p>
                        </div>
                        <p>Lorem ipsum dolor sit ameters consectetur adipisicing elit. Sed qui veroes praesentium maiores, sint eos vero sapiente voluptas debitis dicta dolore.</p>
                        <div class="bottom">
                            <a href="{{ route('student-submission.index', 'Report') }}">Read more</a>
                        </div>
                    </section>
                </div>
                <div class="row row-2">
                    <section>
                        <i class="icon fas fa-rocket"></i>
                        <div class="details">
                            <span class="title">Video demo</span>
                            <span>3rd Jan 2021</span>
                            <p>Status: Pending</p>
                        </div>
                        <p>Lorem ipsum dolor sit ameters consectetur adipisicing elit. Sed qui veroes praesentium maiores, sint eos vero sapiente voluptas debitis dicta dolore.</p>
                        <div class="bottom">
                            <a href="{{ route('student-submission.index', 'Demo') }}">Read more</a>
                        </div>
                    </section>
                </div>
                <div class="row row-1">
                    <section>
                        <i class="icon fas fa-globe"></i>
                        <div class="details">
                            <span class="title">Poster submission</span>
                            <span>4th Jan 2021</span>
                            <p>Status: Pending</p>
                        </div>
                        <p>Lorem ipsum dolor sit ameters consectetur adipisicing elit. Sed qui veroes praesentium maiores, sint eos vero sapiente voluptas debitis dicta dolore.</p>
                        <div class="bottom">
                            <a href="{{ route('student-submission.index', 'Poster') }}">Read more</a>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        
        <!-- Supervisor Details Column -->
        <div class="col-md-4">
            <div class="card supervisor-card">
                <div class="card-body">
                    <h4 class="card-title">Supervisor Details</h4>
                    <p><strong>Name:</strong> {{ $supervisor->user->name }}</p>
                    <p><strong>Email:</strong> {{ $supervisor->user->email }}</p>
                    {{-- <p><strong>Office:</strong> {{ $supervisor->office }}</p> --}}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
