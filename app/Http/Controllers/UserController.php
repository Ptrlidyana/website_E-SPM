<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  public function index()
  {
    $users = User::all();
    return view('admin.data-user', compact('users'));
  }

  // Metode untuk menampilkan detail pengguna berdasarkan ID
  public function show($id)
  {
    $user = User::findOrFail($id); // Mengambil pengguna berdasarkan ID
    return view('admin.user-detail', compact('user')); // Pastikan Anda membuat view 'user-detail.blade.php'
  }
  public function update(Request $request, $id)
  {
    // Validasi data
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|max:255',
      'usertype' => 'required|string|max:255',
      'password' => 'nullable|min:8', // Pastikan password tidak wajib
    ]);

    $user = User::findOrFail($id);

    // Update password hanya jika diisi
    if (!empty($request->password)) {
      $user->password = Hash::make($request->password); // Hash password sebelum disimpan
    }

    // Update kolom lain
    $user->name = $request->name;
    $user->email = $request->email;
    $user->usertype = $request->usertype;
    $user->save();

    return redirect()->route('data.user')->with('success', 'User updated successfully!');
  }
  // UserController.php
  public function dataUser(Request $request)
  {
    $search = $request->input('search');
    $users = User::when($search, function ($query) use ($search) {
      return $query->where('name', 'like', "%{$search}%")
        ->orWhere('username', 'like', "%{$search}%")
        ->orWhere('email', 'like', "%{$search}%");
    })->paginate(10); // Mengatur jumlah data yang ditampilkan per halaman

    return view('admin.data-user', compact('users', 'search'));
  }
  public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('data.user')->with('success', 'User berhasil dihapus.');
    }
}
