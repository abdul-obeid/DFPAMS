<?php

namespace App\Imports;

use App\Models\Cohort;
use App\Models\Project;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    /**
     * Handle the collection of rows.
     *
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                Log::info('Row Data:', $row->toArray());

                $cohortId = $this->cohortId;

                $serialNumber = $row['sno'];
                $numberOfStudents = $row['number_of_students'];
                $student1Id = $row['student1_id'];
                $student1Name = $row['student1_name'];
                $student2Id = $row['student_2_id'];
                $student2Name = $row['student2_name'];
                $projectId = $row['project_id'];
                $projectTitle = $row['project_title'];
                $supervisor = $row['supervisor'];
                $coSupervisor = $row['co_supervisor'];
                $moderator = $row['moderator'];
                $projectType = $row['project_type'];
                $projectSpecialisation = $row['project_specialisation'];


                // Create and save the project
                $project = new Project([
                    'project_mmu_id' => $projectId,
                    'app_or_research' => $projectType,
                    'title' => $projectTitle,
                    'specialization' => $projectSpecialisation,
                    'is_group_project' => ($numberOfStudents > 1),
                    'cohort_id' => $cohortId,
                ]);
                $project->save();

                $s1Password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
                // Create and save Student 1
                $student1User = new User([
                    'name' => $student1Name,
                    'user_type' => 'Student',
                    'email' => $student1Id . '@student.mmu.edu.my',
                    'password' => bcrypt($s1Password),
                    'is_active' => true,
                ]);
                $student1 = new Student([
                    'mmu_student_id' => $student1Id,
                    'cohort_id' => $cohortId,
                    'specialization' => $projectSpecialisation,
                ]);
                $student1->save();
                $student1User->userable()->associate($student1);
                $student1User->save();

                Log::info('Student successfully created. ', ['email' => $student1Id . '@student.mmu.edu.my', 'password' => $s1Password]);

                // Optionally, handle Student 2
                if (!empty($student2Id)) {
                    $s2Password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
                    $student2User = new User([
                        'name' => $student2Name,
                        'user_type' => 'Student',
                        'email' => $student2Id . '@student.mmu.edu.my',
                        'password' => bcrypt($s2Password),
                        'is_active' => true,
                    ]);
                    $student2 = new Student([
                        'mmu_student_id' => $student2Id,
                        'cohort_id' => $cohortId,
                        'specialization' => $projectSpecialisation,
                    ]);
                    $student2->save();
                    $student2User->userable()->associate($student2);
                    $student2User->save();

                    Log::info('Student successfully created. ', ['email' => $student2Id . '@student.mmu.edu.my', 'password' => $s2Password]);
                }

                $existingSupervisorUser = User::where('name', $supervisor)
                    ->where('user_type', 'Supervisor')
                    ->first();

                if ($existingSupervisorUser) {
                    // Supervisor already exists
                    $supervisor = $existingSupervisorUser->userable; // Get the associated Supervisor model
                } else {
                    // Supervisor does not exist, create new Supervisor and User
                    $supPassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
                    $supervisorUser = new User([
                        'name' => $supervisor,
                        'user_type' => 'Supervisor',
                        'email' => str_replace(' ', '.', strtolower($supervisor)) . '@mmu.edu.my',
                        'password' => bcrypt($supPassword),
                        'is_active' => true,
                    ]);

                    $supervisor = new Supervisor(['cohort_id' => $cohortId]);
                    $supervisor->save();

                    $supervisorUser->userable()->associate($supervisor);
                    $supervisorUser->save();

                    Log::info('Supervisor successfully created. ', ['name' => $row['supervisor'], 'email' => str_replace(' ', '.', strtolower($row['supervisor'])) . '@mmu.edu.my', 'password' => $supPassword]);
                }

                // Attach students and supervisor to the project
                $project->students()->attach($student1->id);
                if (!empty($student2Id)) {
                    $project->students()->attach($student2->id);
                }
                $project->supervisor()->attach($supervisor->id);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Error with importing data from excel file: ' . $e->getMessage() . ' ' . $e->getTraceAsString());
        }
    }

    /**
     * Define validation rules for the import.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
        //     '*.S.No.' => 'nullable|integer',
        //     '*.Number of Students' => 'required|integer',
        //     '*.Student1_ID' => 'required|string',
        //     '*.Student1_Name' => 'required|string',
        //     '*.Student2_ID' => 'nullable|string',
        //     '*.Student2_Name' => 'nullable|string',
        //     '*.Project ID' => 'required|string',
        //     '*.Project Title' => 'required|string',
        //     '*.Supervisor' => 'required|string',
        //     '*.Co_Supervisor' => 'nullable|string',
        //     '*.Moderator' => 'nullable|string',
        //     '*.Project Type' => 'required|string',
        //     '*.Project Specialisation' => 'required|string',
        // ];
        // return [
        //     'Number of Students' => 'required|integer',
        //     'Student1_ID' => 'required|string',
        //     'Student1_Name' => 'required|string',
        //     'Student2_ID' => 'nullable|string',
        //     'Student2_Name' => 'nullable|string',
        //     'Project ID' => 'required|string',
        //     'Project Title' => 'required|string',
        //     'Supervisor' => 'required|string',
        //     'Co_Supervisor' => 'nullable|string',
        //     'Moderator' => 'nullable|string',
        //     'Project Type' => 'required|string',
        //     'Project Specialisation' => 'required|string',
        // ];
    }
}
