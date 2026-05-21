<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // 1. View all users
    public function index()
    {
        // Fetch users with their roles, sorted by newest first
        $users = User::with('role')->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    // 2. Show Edit Form
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    // 3. Save Updates
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User account updated successfully.');
    }

    // 4. Delete User
    public function destroy(User $user)
    {
        // Prevent the admin from deleting themselves
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account while logged in.');
        }

        $user->delete();
        return back()->with('success', 'User account has been permanently deleted.');
    }
}