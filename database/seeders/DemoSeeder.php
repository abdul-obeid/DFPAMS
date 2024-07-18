<?php

namespace Database\Seeders;


use App\Models\Cohort;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\Project;
use App\Models\Coordinator;
use App\Models\ProjectStudents;
use App\Models\SupervisedProjects;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $cohortStartDate = $faker->dateTimeBetween('-6 months', '+6 months');
        Cohort::create([
            'start_date' => $cohortStartDate,
            'end_date' => Carbon::parse($cohortStartDate)->addMonths('6'),
            'faculty' => 'FCI',
            'trimester_code' => $faker->unique()->numerify('2###'),
        ]);

        $currentCohortId = Cohort::all()->last()->id;
        for ($i = 0; $i < 75; $i++) {
            $student = Student::create([
                'mmu_student_id' => $faker->unique()->numerify('12########'),
                'cohort_id' => $currentCohortId,
                'specialization' => $faker->randomElement(['Software Engineering', 'Cybersecurity', 'Game Development', 'Data Science']),
            ]);
            $user = $student->user()->create([
                'name' => $faker->name(),
                'username' => $faker->unique()->userName(),
                'user_type' => 'student',
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'), // Set a default password
                'is_active' => true,
            ]);
        }

        for ($i = 0; $i < 25; $i++) {
            $supervisor = Supervisor::create([
                'cohort_id' => $currentCohortId,
            ]);
            $user = $supervisor->user()->create([
                'name' => $faker->name(),
                'username' => $faker->unique()->userName(),
                'user_type' => 'supervisor',
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'), // Set a default password
                'is_active' => true,
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            $coordinator = Coordinator::create([
                'cohort_id' => $currentCohortId,
            ]);
            $user = $coordinator->user()->create([
                'name' => $faker->name(),
                'username' => $faker->unique()->userName(),
                'user_type' => 'coordinator',
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'), // Set a default password
                'is_active' => true,
            ]);
        }



        // Get all students
        $allStudents = Student::all();

        // Shuffle and select 10 random students
        $groupProjStudents = $allStudents->shuffle()->take(10);

        // Get the remaining users
        $indivProjStudents = $allStudents->diff($groupProjStudents);


        //Create and assign individual projects to students
        foreach ($indivProjStudents as $student) {
            $proj = Project::create(
                [
                    'title' => $faker->sentence(),
                    'specialization' => $student->specialization,
                    'is_group_project' => false,
                    'cohort_id' => Cohort::all()->last()->id,
                ]
            );

            ProjectStudents::create(
                [
                    'project_id' => $proj->id,
                    'student_id' => $student->id,
                ]
            );
        }
        //Create and assign group projects to students
        for ($i = 0; $i < $groupProjStudents->count(); $i += 2) {
            // Check if there are at least two students left
            if ($i + 1 < $groupProjStudents->count()) {
                // Create a project for each pair of students
                $project = Project::create([
                    'title' => $faker->sentence(1),
                    'specialization' => $groupProjStudents[$i]->specialization,
                    'is_group_project' => true,
                    'cohort_id' => Cohort::all()->last()->id,
                ]);

                // Link the students to the project
                ProjectStudents::create([
                    'project_id' => $project->id,
                    'student_id' => $groupProjStudents[$i]->id
                ]);

                ProjectStudents::create([
                    'project_id' => $project->id,
                    'student_id' => $groupProjStudents[$i + 1]->id
                ]);
            }
        }

        $allProjects = Project::all();
        foreach ($allProjects as $project) {
            $randomSupervisor = Supervisor::inRandomOrder()->first();
            SupervisedProjects::create(
                [
                    'supervisor_id' => $randomSupervisor->id,
                    'project_id' => $project->id,
                ]
            );
        }
    }
}
