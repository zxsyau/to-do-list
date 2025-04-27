<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Task;
use App\Models\User;
use App\Models\UserTask;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function createJob()
    {
        return view('page.createjob');
    }

    public function postJob(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $job = Job::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id()
        ]);

        if (!$job) {
            return redirect()->back()->withErrors(['errors' => 'Failed to create job']);
        }
        return redirect()->route('dashboard')->with(['message' => 'Job created successfully']);
    }

    public function editJob(Request $request, $id)
    {
        $job = Job::find(id: $id);

        $type = $request->query('type');
        if ($type == 'tasker') {
            $users = User::where('role', 'tasker')->get();
        } elseif ($type == 'worker') {
            $users = User::where('role', 'worker')->get();
        } else {
            $users = User::where('role', 'admin')->get();
        }

        return view('page.editjob', compact('job', 'type', 'users'));
    }

    public function postEditJob(Request $request, $id)
    {
        $job = Job::find($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $job->update([
            'title' => $request->title,
            'description' => $request->description
        ]);
        return redirect()->route('dashboard', ['id' => $job->job_id])->with(['message' => 'Job updated successfully']);
    }

    public function deleteJob(Request $request)
    {
        $job = Job::find($request->id);
        $job->delete();
        return redirect()->route('dashboard')->with(['message' => 'job delete successfully']);
    }

    public function detail(Request $request, $id)
    {
        $type = $request->query('type');

        if ($type == 'tasker') {
            $users = User::where('role', 'tasker')->get();
        } elseif ($type == 'worker') {
            $users = User::where('role', 'worker')->get();
        } else {
            $users = User::where('role', 'admin')->get();
        }

        $user = Auth::user();
        $userTasks = collect();

        if ($user->role == 'tasker') {
            $job = Job::where('id', $id)->where('user_id', $user->id)->firstOrFail();
            $filteredTasks = Task::where('job_id', $job->id)->get();
        } elseif ($user->role == 'worker') {
            $job = Job::where('id', $id)->where('user_id', $user->id)->first();

            if ($job) {
                // milik worker itu sendiri
                $filteredTasks = Task::where('job_id', $job->id)->get();
            } else {
                // dari tasker
                $job = Job::findOrFail($id);
                $allTasks = Task::where('job_id', $job->id)->get();
                $taskIds = $allTasks->pluck('id')->toArray();

                $userTasks = UserTask::where('user_id', $user->id)
                    ->whereIn('task_id', $taskIds)
                    ->pluck('task_id')
                    ->toArray();

                $filteredTasks = $allTasks->whereIn('id', $userTasks);
            }
        }

        return view('page.detail', [
            'job' => $job,
            'user' => $user,
            'task' => $filteredTasks,
            'userTasks' => $userTasks,
            'type' => $type,
            'users' => $users,
        ]);
    }
}
