<!-- resources/views/admin-dashboard.blade.php -->
@extends('templates.main-page-template')

@section('content')
<div class="container mt-5">
    <h1>Admin Dashboard</h1>
    <table id="cohort-table"class="table table-striped">
        <thead>
            <h2>FYP Cohorts</h2>
            <tr>
                <th>Trimester Code</th>
                <th>Cohort Start Date</th>
                <th>Cohort End Date</th>
                <th>Number of Students</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cohorts as $cohort)
            <tr>
                <td>{{ $cohort->trimester_code }}</td>
                <td>{{ $cohort->start_date }}</td>
                <td>{{ $cohort->end_date }}</td>
                <td>{{ $cohort->students()->count()}}</td>
                <td>
                    <a href="{{ route('cohort.index', $cohort->id) }}" class="btn btn-primary">View Details</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <!-- Button to Open the Modal -->
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#configureCohortModal">
        Configure New Cohort
    </button>

    <!-- The Modal -->
    <div class="modal fade" id="configureCohortModal" tabindex="-1" aria-labelledby="configureCohortModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="configureCohortModalLabel">Configure New Cohort</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="configureCohortForm" action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control flatpickr" id="start_date" name="start_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control flatpickr" id="end_date" name="end_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="student_details" class="form-label">Student & Supervisor Details (CSV)</label>
                            <input type="file" class="form-control" id="student_details" name="student_details" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#cohort-table').DataTable();
    });
</script>

@endsection
