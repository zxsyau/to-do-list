<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function users(Request $request)
    {
        $type = request()->type;
        if ($type == "admin") {
            $users = User::where('role', 'admin')->get();
        } elseif ($type == 'tasker') {
            $users = User::where('role', 'tasker')->get();
        } else {
            $users = User::where('role', 'worker')->get();
        }

        return view('admin.users', compact('type', 'users'));
    }

    public function createUser()
    {
        $type = request()->type;
        if ($type == "admin") {
            $users = User::where('role', 'admin')->get();
        } elseif ($type == 'tasker') {
            $users = User::where('role', 'tasker')->get();
        } else {
            $users = User::where('role', 'worker')->get();
        }
        return view('admin.createuser', compact('type', 'users'));
    }

    public function postUsers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'role' => 'required|string|in:tasker,worker',
            'phone_number' => 'required|string|max:14|unique:users',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);

        if (!$user) {
            return redirect()->back()->withErrors(['errors' => 'Failed to create user']);
        }
        return redirect()->route('users')->with(['message' => 'User created successfully']);
    }

    public function editUser(Request $request, $id){
        $user = User::find($id);

        $type = $request->query('type');
        if ($type == 'tasker') {
            $users = User::where('role', 'tasker')->get();
        } elseif ($type == 'worker') {
            $users = User::where('role', 'worker')->get();
        }else{
            $users = User::where('role', 'admin')->get();
        }

        return view('admin.edituser', compact( 'user', 'users', 'type'));
    }

    public function postEditUser(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->withErrors(['error', 'Invalid credential']);
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:14|unique:users,phone_number,' . $user->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $user->update([
            'username' => $request->username,
            'name' => $request->name,
            'phone_number' => $request->phone_number,
        ]);
        return redirect()->route('users', ['type' => $user->role])->with('success', 'User updated successfully');
    }

    public function postDeleteUser(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();
        return redirect()->back()->with(['message' => 'user delete successfully']);
    }
}
