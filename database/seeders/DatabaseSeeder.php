<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserTask;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'phone_number' => '12341266890',
            'role' => 'admin',
            'password' => 'password',
        ]);

        User::create([
            'name' => 'Tasker',
            'username' => 'tasker',
            'phone_number' => '1234567891',
            'role' => 'tasker',
            'password' => 'password',
        ]);

        User::create([
            'name' => 'Worker',
            'username' => 'worker',
            'phone_number' => '1234567892',
            'role' => 'worker',
            'password' => 'password',
        ]);

        Job::create([
            'title'=> 'Job 1',
            'description'=> 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus, natus?',
            'user_id'=> 2,
        ]);

        Task::create([
            'title'=> 'Task 1',
            'description'=> 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus, natus?',
            'job_id'=> 1,
        ]);

        Task::create([
            'title'=> 'Task 2',
            'description'=> 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus, natus?',
            'job_id'=> 1,
        ]);

        UserTask::create([
            'user_id'=> 3,
            'task_id'=> 1,
            'file_proof'=> 'file_proof.txt',
            'completed_at'=> now(),
        ]);
    }
}
