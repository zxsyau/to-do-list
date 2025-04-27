<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request){
        $user = $request->user();
        if(auth()->user()->role == 'admin'){
            $users = User::all();
            return view('dashboard',compact('users'));
        }elseif(auth()->user()->role == 'tasker'){
            $jobs = Job::where('user_id', $user->id)->get();
            return view('dashboard',compact('jobs'));
        }else{
            $jobs = Job::whereHas('tasks.userTasks', function ($userTask) use ($user) {
                $userTask->where('user_id', $user->id);
            })->orWhere('user_id', $user->id)->get();
            $taskerJobs = $jobs->filter(fn($job) => $job->user_id != auth()->id());
        }


        return view('dashboard', compact('taskerJobs', 'jobs'));
    }
}
