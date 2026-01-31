<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return view('user.all-user', compact('user'));
    }

    public function form()
    {
        return view("user.form-user");
    }

    public function createStore(Request $request)
    {
        $validated = $request->validate([
            'role'     => 'required',
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone'    => 'required',
            'address'  => 'required',
        ]);

        User::create([
            'role'     => $request->role,
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'address'  => $request->address,
        ]);

        return response()->json([
            'message' => 'User berhasil ditambahkan'
        ], 201);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit-user', compact('user'));
    }


    public function saveChanges(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'role'     => 'required',
            'phone'    => 'nullable',
            'address'  => 'nullable',
            'password' => 'nullable|min:6',
        ]);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return response()->json([
            'message' => 'User berhasil diperbarui'
        ], 200);
    }


    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return response()->json([
            'message' => 'User berhasil dihapus'
        ], 200);
    }
}
