@extends('templates.main-page-template')

@section('content')
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Specialization</th>
            <th>Cohort</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
            <tr>
                <td>{{ $student->mmu_student_id }}</td>
                <td>{{ $student->useable->name }}</td>
                <td>{{ $student->specialization }}</td>
                <td>{{ $student->cohort }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection