<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Task;
use App\Models\User;
use App\Models\UserTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function detailTask(Request $request, $id)
    {
        $detailTask = Task::find($id);
        $workers = User::where('role', 'worker')->get();
        return view('page.detailtask', compact('workers', 'detailTask'));
    }

    public function createTask($job_id)
    {
        $job = Job::find($job_id);
        return view("page.createTask", compact('job'));

    }

    public function postTask(Request $request, $job_id)
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $job = Job::findOrFail($job_id);
        if ($job->user_id !== auth()->id()) {
            abort(403, 'Kamu tidak berhak menambahkan task pada job ini.');
        }

        $task = Task::create([
            'title' => request()->title,
            'description' => request()->description,
            'job_id' => $job_id,
        ]);

        if($task && auth()->user()->role == 'worker'){
            UserTask::create([
                'user_id' => auth()->id(),
                'task_id' => $task->id,
            ]);
        }

        if ($task) {
            return redirect()->route('detail', ['id' => $job_id])
                ->with('success', 'Task berhasil dibuat!');
        }
        return redirect()->back()->withErrors('error', 'Invalid credential');
    }

    public function editTask($job_id)
    {
        $task = Task::find($job_id);

        return view('page.edittask', compact('task'));
    }

    public function postEditTask(Request $request, $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return redirect()->back()->withErrors('Task tidak ditemukan');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('detail', ['id' => $task->job_id])->with('success', 'Task berhasil diupdate!');
    }

    public function deleteTask(Request $request)
    {
        $task = Task::find($request->id);
        $task->delete();
        return redirect()->route('detail', ['id' => $task->job_id])->with(['message' => 'Task delete successfully']);
    }

    public function assignWorker(Request $request, $id)
    {
        $task = Task::find($id);
        $workers = User::where('role', 'worker')->get();
        $assignedWorkerIds = UserTask::where('task_id', $id)->pluck('user_id')->toArray();

        return view('page.assignworker', compact('task', 'workers', 'assignedWorkerIds'));
    }

    public function postAssign(Request $request, $id)
    {
        // $task = Task::findOrFail($id);
        $newWorkerIds = $request->input('worker_ids', []);
        $existingWorkerIds = UserTask::where('task_id', $id)->pluck('user_id')->toArray();

        $additions = array_diff($newWorkerIds, $existingWorkerIds);
        foreach ($additions as $userId) {
            UserTask::create([
                'task_id' => $id,
                'user_id' => $userId,
            ]);
        }

        UserTask::where('task_id', $id)
            ->whereIn('user_id', array_diff($existingWorkerIds, $newWorkerIds))
            ->delete();

        return redirect()->route('detailTask', ['id' => $id])->with('success', 'Worker berhasil diperbarui!');
    }

    public function uploadProof($id)
    {
        $task = Task::find($id);
        $userTask = UserTask::where('task_id', $id)
            ->where('user_id', auth()->id())
            ->first();
        return view('page.uploadproof', compact('task', 'userTask'));
    }

    public function postProof(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'file_proof' => 'required|mimes:jpeg,png,jpg,docx,xlsx,pdf,zip|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $user = $request->user();

        $userTask = UserTask::where('task_id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$userTask) {
            return redirect()->back()->with('error', 'Kamu tidak ditugaskan untuk task ini!');
        }

        $file = $request->file('file_proof');
        $filePath = 'tasks/' . $id . '/users/' . $user->id;
        $fileName = $file->hashName();
        $file->storeAs($filePath, $fileName, 'public');

        $userTask->file_proof = $filePath . '/' . $fileName;
        $userTask->completed_at = now();
        $userTask->save();
        return back()->with('success', 'Bukti tugas berhasil diunggah!');
    }
}
