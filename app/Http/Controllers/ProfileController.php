<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;


class ProfileController extends Controller
{
  /**
   * Display the user's profile form.
   */
  public function edit(Request $request): View
  {
    return view('profile.edit', [
      'user' => $request->user(),
    ]);
  }

  /**
   * Update the user's profile information.
   */
  public function update(ProfileUpdateRequest $request): RedirectResponse
  {
    $request->user()->fill($request->validated());

    if ($request->user()->isDirty('email')) {
      $request->user()->email_verified_at = null;
    }

    $request->user()->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
  }

  /**
   * Delete the user's account.
   */
  public function destroy(Request $request): RedirectResponse
  {
    $request->validateWithBag('userDeletion', [
      'password' => ['required', 'current_password'],
    ]);

    $user = $request->user();

    Auth::logout();

    $user->delete();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return Redirect::to('/');
  }

  /**
   * Update the user's password.
   */
  public function updatePassword(Request $request): RedirectResponse
  {
    // Validasi input
    $request->validate([
      'current_password' => 'required',
      'new_password' => 'required|min:8|confirmed',
    ], [
      'new_password.min' => 'Kata sandi baru harus terdiri dari minimal 8 karakter.',
      'new_password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
      'current_password.required' => 'Kata sandi lama harus diisi.',
    ]);

    // Cek apakah kata sandi lama sesuai
    if (!Hash::check($request->current_password, Auth::user()->password)) {
      return redirect()->back()->withErrors(['current_password' => 'Mohon Maaf, Kata Sandi Lama Anda Tidak Sesuai.']);
    }

    // Update kata sandi
    $user = Auth::user();
    $user->password = Hash::make($request->new_password);
    $user->save();

    // Berhasil
    return redirect()->back()->with('status', 'Selamat! Kata Sandi Anda Telah Berhasil.');
  }
}
