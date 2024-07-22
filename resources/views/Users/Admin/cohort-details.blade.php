@extends('templates.main-page-template')

@section('content')
<div class="container">
    <h1 class="display-5">FYP Session {{$cohort->trimester_code}}</h1>
    <!-- Main Statistics Boxes -->
    <div class="row mb-4">
        <!-- Number of Students Box -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Number of Students
                </div>
                <div class="card-body">
                    <h3>{{ $totalStudents }}</h3>
                    @foreach($specializations as $specialization => $count)
                        <div class="alert alert-primary">
                            {{ $specialization }}: {{ $count }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Number of Projects Box -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Number of Projects
                </div>
                <div class="card-body">
                    <h3>{{ $totalProjects }}</h3>
                    <div class="alert alert-success">
                        Group Projects: {{ $groupProjects }}
                    </div>
                    <div class="alert alert-warning">
                        Individual Projects: {{ $individualProjects }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Project Submissions Box -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Project Submissions
                </div>
                <div class="card-body text-center">
                    @php
                        $submissionPercentage = $totalProjects > 0 ? ($submittedProjects / $totalProjects) * 100 : 0;
                    @endphp
                    <div class="d-flex justify-content-center">
                        <div class="position-relative">
                            <canvas id="submissionChart" width="200" height="200"></canvas>
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <h4>{{ number_format($submissionPercentage, 2) }}%</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('submissionChart').getContext('2d');
    var submissionChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Submitted', 'Not Submitted'],
            datasets: [{
                data: [{{ $submittedProjects }}, {{ $totalProjects - $submittedProjects }}],
                backgroundColor: ['#36A2EB', '#FF6384']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
