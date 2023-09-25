<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index');
    }

    public function store(Request $request)
    {   
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:users'],
            'email' => ['required', 'string', 'max:50', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:200', 'confirmed'],
        ]);
         
        User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'lang' => Cache::get($_SERVER['REMOTE_ADDR'] . '-lang'),
            'darkTheme' => Cache::get($_SERVER['REMOTE_ADDR'] . '-darkTheme'),
        ]);

        if (isset($request['remember'])) {
            $remember = true;
        } else {
            $remember = false;
        }

        if (Auth::attempt($validated, $remember)) {
            $request->session()->regenerate();

            return redirect()->route('home.index');
        }

        return redirect()->route('register.index')->withErrors('Something went wrong');
    }
}