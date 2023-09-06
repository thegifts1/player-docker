<?php

namespace App\Http\Controllers;

require_once '/var/www/html/app/getID3/getid3/getid3.php';

use App\Models\Music;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AddMusicController extends Controller
{
    public function index()
    {
        return view('addMusic.index');
    }

    public function store(Request $request)
    {
        if (!empty($request['fileUpload'])) {
            $user = new User;
            $user->name = Auth::user()->name;

            $allowedExtensions = ['mp3', 'ogg', 'wav'];

            $file_count = count($request->file('fileUpload'));

            $getID3 = new \getID3();
            $getID3->encoding = 'UTF-8';

            $check = DB::table('music')->where('name', $user['name'])->get(['track_name']);
            $check_count = count($check);

            for ($i = 0; $i < $file_count; $i++) {
                $uploadedFile = $request->file('fileUpload')[$i];

                $ThisFileInfo = $getID3->analyze($uploadedFile);
                
                $file_name = $request->file('fileUpload')[$i]->getClientOriginalName();

                $extension = pathinfo($file_name = $request->file('fileUpload')[$i]->getClientOriginalName(), PATHINFO_EXTENSION);
                if (!in_array($extension, $allowedExtensions)) {
                    return redirect()->route('addMusic.index')->withErrors('Uploading files with this permission is prohibited');
                }

                for ($i2 = 0; $i2 < $check_count; $i2++) {
                    if ($check[$i2]->track_name == $file_name) {
                        return redirect()->route('addMusic.index')->withErrors('You have already added a file with this name: ' . $file_name);
                    }
                }

                $dbSong = Music::query()->create([
                    'name' => $user['name'],
                    'track_name' => $file_name,
                    'duration' => $ThisFileInfo['playtime_string'],
                    'size' => ($ThisFileInfo['filesize'] / 1024) / 1024,
                ]);

                Storage::disk('public')->putFileAs(
                    'UsersMusic/' . $user['name'],
                    $uploadedFile,
                    $file_name,
                );
            }
        } else {
            return redirect()->route('addMusic.index')->withErrors('Load Music');
        }

        return redirect()->route('home.index');
    }
}