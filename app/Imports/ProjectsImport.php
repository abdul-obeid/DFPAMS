<?php

namespace App\Imports;

use App\Models\Cohort;
use App\Models\Project;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;

class ProjectsImport implements ToCollection, WithHeadingRow, WithValidation
{
    protected $cohortId;

    /**
     * Create a new import instance.
     *
     * @param int $cohortId
     */
    public function __construct($cohortId)
    {
        $this->cohortId = $cohortId;
    }

    public function model(array $row)
    {
        $cohortId = $this->cohortId;

        $serialNumber = $row['S.No.'];
        $numberOfStudents = $row['Number of Students'];
        $student1Id = $row['Student1_ID'];
        $student1Name = $row['Student1_Name'];
        $student2Id = $row['Student2_ID'];
        $student2Name = $row['Student2_Name'];
        $projectId = $row['Project ID'];
        $projectTitle = $row['Project Title'];
        $supervisor = $row['Supervisor'];
        $coSupervisor = $row['Co_Supervisor'];
        $moderator = $row['Moderator'];
        $projectType = $row['Project Type'];
        $projectSpecialisation = $row['Project Specialisation'];

        $projectDetails = [
            'project_mmu_id' => $projectId,
            'app_or_research' => $projectType,
            'title' => $projectTitle,
            'specialization' => $projectSpecialisation,
            'is_group_project' => ($numberOfStudents > 1) ? true : false,
            'cohort_id' => $cohortId
        ];
        $projectModel = new Project($projectDetails);

        $student1UserDetails = [
            'name' => $student1Name,
            'user_type' => 'Student',
            'email' => $student1Id . '@student.mmu.edu.my',
            'password' => preg_replace('/[\'"\\\]/', '', Str::random(12)),
            'is_active' => true,
        ];

        $student1Details = [
            'mmu_student_id' => $student1Id,
            'cohort_id' => $cohortId,
            'specialization' => $projectSpecialisation
        ];

        $student1UserModel = new User($student1UserDetails);
        $student1Model = new Student($student1Details);


        $student1UserModel->userable()->associate($student1Model);
        $student1UserModel->save();


        $student2UserDetails = [];
        $student2Details = [];
        if (!empty($row['Student2_ID'])) {
            $student2UserDetails = [
                'name' => $student2Name,
                'user_type' => 'Student',
                'email' => $student2Id . '@student.mmu.edu.my',
                'password' => preg_replace('/[\'"\\\]/', '', Str::random(12)),
                'is_active' => true,
            ];
            $student2Details =
                [
                    'mmu_student_id' => $student2Id,
                    'cohort_id' => $cohortId,
                    'specialization' => $projectSpecialisation
                ];

            $student2UserModel = new User($student2UserDetails);
            $student2Model = new Student($student2Details);


            $student2UserModel->userable()->associate($student2Model);
            $student2UserModel->save();
        }

        $supervisorUserDetails = [
            'name' => $supervisor,
            'user_type' => 'Supervisor',
            'email' => str_replace(' ', '.', strtolower($supervisor)) . '@mmu.edu.my',
            'password' => preg_replace('/[\'"\\\]/', '', Str::random(12)),
            'is_active' => true,
        ];
        $supervisorDetails = [
            'cohort_id' => $cohortId,
        ];

        $supervisorUserModel = new User($supervisorUserDetails);
        $supervisorModel = new Supervisor($supervisorDetails);


        $supervisorUserModel->userable()->associate($supervisorModel);
        $supervisorUserModel->save();

        $projectModel->students()->attach($student1Model->id);
        if (!empty($student2Details)) {
            $projectModel->students()->attach($student2Model->id);
        }

        $projectModel->supervisor()->attach($supervisorModel->id);
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Process each row here
            // Example: 
            // $project = new Project();
            // $project->title = $row['project_title'];
            // $project->save();
        }
    }

    public function rules(): array
    {
        return [
            '*.s_no' => 'required|integer',
            '*.number_of_students' => 'required|integer',
            '*.student1_id' => 'required|string',
            '*.student1_name' => 'required|string',
            '*.student2_id' => 'nullable|string',
            '*.student2_name' => 'nullable|string',
            '*.project_id' => 'required|string',
            '*.project_title' => 'required|string',
            '*.supervisor' => 'required|string',
            '*.co_supervisor' => 'nullable|string',
            '*.moderator' => 'nullable|string',
            '*.project_type' => 'required|string',
            '*.project_specialisation' => 'required|string',
        ];
    }
}
