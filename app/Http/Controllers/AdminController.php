<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }
   
    public function createAdmin(Request $request)
    {
        if ($request->isMethod('POST')) {
            // Handle form submission
        }

        return $this->render('admin/create.html.twig');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:Super Admin,Admin,Teacher,Student,Guest',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return response()->json(['message' => 'Admin created successfully', 'user' => $user], 201);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('Admin.edit_user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string|in:Super Admin,Admin,Teacher,Student,Guest',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('adminlist')->with('success', 'User updated successfully.');
    }

}
