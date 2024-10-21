<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
  /**
   * Display the registration view.
   */
  public function create(): View
  {
    return view('auth.register');
  }

  /**
   * Handle an incoming registration request.
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function store(Request $request): RedirectResponse
  {
    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
      'birth_date' => ['required', 'date'],
    ]);

    $name = $request->name;
    $birth_date = $request->birth_date;

    $username = substr($name, 0, 3) . date('dmy', strtotime($birth_date));

    $user = User::create([
      'name' => $name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'birth_date' => $birth_date,
      'username' => $username,
    ]);

    event(new Registered($user));

    Auth::login($user);

    return redirect('dashboard');
  }
}
