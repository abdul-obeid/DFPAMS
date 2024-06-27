<?php

namespace Database\Seeders;


use App\Models\Cohort;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\Project;
use App\Models\Coordinator;
use App\Models\User;
use App\Models\UserRoles;
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
            'trimester_code' => '2401',
        ]);

        foreach (range(1, 100) as $index) {
            User::create([
                'name' => $faker->name(),
                'username' => $faker->unique()->userName(),
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'), // Set a default password
                'is_active' => true,
            ]);
        }

        $coordinators = User::take(5)->get(); // First 10 users
        $supervisors = User::skip(5)->take(20)->get(); // Next 20 users
        $students = User::skip(25)->take(75)->get(); // Next 20 users after the first 30


        foreach ($students as $user) {
            Student::create([
                'user_id' => $user->id,
                'mmu_student_id' => $faker->unique()->numerify('12########'),
                'cohort_id' => Cohort::all()->last()->id,
                'specialization' => $faker->randomElement(['Software Engineering', 'Cybersecurity', 'Game Development', 'Data Science']),
            ]);
        }

        foreach ($coordinators as $user) {
            Coordinator::create(
                [
                    'user_id' => $user->id,
                    'cohort_id' => Cohort::all()->last()->id,
                ]
            );
        }

        foreach ($supervisors as $user) {
            Supervisor::create(
                [
                    'user_id' => $user->id,
                    'cohort_id' => Cohort::all()->last()->id,
                ]
            );
        }

        // Get all users
        $allStudents = Student::all();

        // Shuffle and select 10 random users
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
