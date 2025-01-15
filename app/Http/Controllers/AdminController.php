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
    /**
     * @Route("/create_admin", name="create_admin", methods={"GET", "POST"})
     */
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
}
