<?php

namespace App\Http\Controllers;

use App\Models\EmailLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function loginName()
    {
        return view('login.loginName');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'min:7', 'max:200'],
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

        return redirect()->route('login.index')->withErrors('Something went wrong');
    }

    public function loginEmail()
    {
        return view('login.loginEmail');
    }

    public function loginEmailStore(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users'
        ]);

        $emailLogin = EmailLogin::createForEmail($request->input('email'));

        $url = route('login.emailCodeConfirm', [
            'token' => $emailLogin->token
        ]);

        Mail::send('emails.login.emailLogin', ['url' => $url], function ($m) use ($request) {
            $m->from('nikitamartynuk30362@gmail.com', "Songs");
            $m->to($request->input('email'))->subject('Songs Login');
        });

        return redirect()->route('home.index');
    }

    public function authenticateEmail($token)
    {
        $emailLogin = EmailLogin::validFromToken($token);

        Auth::login($emailLogin->user, $remember = true);

        return redirect()->route('home.index');
    }
}
