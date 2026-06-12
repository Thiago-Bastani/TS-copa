<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:50', 'unique:users', 'regex:/^[a-zA-Z0-9_\-]+$/'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'pix_key'  => ['required', 'string', 'max:100'],
        ], [
            'name.regex' => 'O usuário só pode conter letras, números, hífen e underline.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'password' => Hash::make($request->password),
            'pix_key'  => $request->pix_key,
            'role'     => 'user',
        ]);

        Auth::login($user);

        return redirect('/matches');
    }
}
