<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function test()
    {
        return response()->json(['message' => 'Test route is working on user']);
    }

    public function index()
    {
        $users = User::with('instanses', 'grup')->get();

        return response()->json($users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password, // Hanya untuk tujuan debugging
                'grup_id' => $user->grup_id,
                'instanses_id' => $user->instanses_id,
                'grup' => $user->grup,
                'instanses' => $user->instanses,
            ];
        }), 200);

        return response()->json($users, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'grup_id' => 'required|exists:grups,id',
            'instanses_id' => 'required|exists:instanses,id',
        ]);

        // Default password
        $defaultPassword = 'password123';

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($defaultPassword), // Hash the default password
            'grup_id' => $validatedData['grup_id'],
            'instanses_id' => $validatedData['instanses_id'],
        ]);

        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        // Validate input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'grup_id' => 'required|exists:grups,id',
            'instanses_id' => 'required|exists:instanses,id',
            'password' => 'nullable|string|min:6', // Password is optional
        ]);

        // Find user by ID
        $user = User::findOrFail($id);

        // Update user data
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->grup_id = $validatedData['grup_id'];
        $user->instanses_id = $validatedData['instanses_id'];

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        // Save changes
        $user->save();

        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }
}
