<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function changeThemeNotAuth(Request $request)
    {        
        if (isset($request['darkTheme'])) {
            Cache::put($_SERVER['REMOTE_ADDR'] . '-darkTheme', 1, now()->addYears(30));
        } else if (isset($request['lightTheme'])) {
            Cache::put($_SERVER['REMOTE_ADDR'] . '-darkTheme', 0, now()->addYears(30));
        }

        return redirect()->back();
    }

    public function changeThemeForAuth(Request $request)
    {
        $user = Auth::user();

        if (isset($request['darkTheme'])) {
            User::query()->where('id', $user['id'])->update(['darkTheme' => 1]);
        } else {
            User::query()->where('id', $user['id'])->update(['darkTheme' => 0]);
        }

        return redirect()->back();
    }

    public function changeLangNotAuth(Request $request)
    {
        if ($request['lang'] == 'Rus') {
            Cache::put($_SERVER['REMOTE_ADDR'] . '-lang', 'ru', now()->addYears(30));
        } else if ($request['lang'] == 'Eng') {
            Cache::put($_SERVER['REMOTE_ADDR'] . '-lang', 'en', now()->addYears(30));
        }

        return redirect()->back();
    }

    public function changeLangForAuth(Request $request)
    {
        $user = Auth::user();

        if ($request['lang'] == 'Rus') {
            User::query()->where('id', $user['id'])->update(['lang' => 'ru']);
        } else if ($request['lang'] == 'Eng') {
            User::query()->where('id', $user['id'])->update(['lang' => 'en']);
        }

        return redirect()->back();
    }
}
