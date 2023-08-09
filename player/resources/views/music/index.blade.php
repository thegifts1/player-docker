@extends('layouts.base')

@section('title', 'Music')

@section('content')
    @guest
        {{ __('Log in first') }}
    @endguest

    @auth
        @php
            $counter++;
            $nowPlaying = '';
            $arrayForCheck = [];
            
            if (!isset($_COOKIE['idSong'])) {
                $_COOKIE['idSong'] = 0;
            }
            
            for ($i = 0; $i < $counter; $i++) {
                array_push($arrayForCheck, $i);
            }
            
            for ($i = 1; $i < $counter; $i++) {
                if ($_COOKIE['idSong'] == $arrayForCheck[$i]) {
                    $nowPlaying = $songs[$i]['track_name'];
                    break;
                }
            }
        @endphp

        <div class="now_play">
            {{ __('Now playing: ') }}
            <?= $nowPlaying ?>
        </div>
        <img onclick="past()" class="arrow" src="img/svg/left-arrow.svg" alt="left">
        <img onclick="next()" class="arrow" src="img/svg/right-arrow.svg" alt="right">
        <div id="player_container">
            <audio controls autoplay id="player" class="player"
                src="../storage/app/UsersMusic/<?= Auth::user()->name . '/' . $nowPlaying ?>"></audio>
        </div>
        <table class="music_table">
            <tr class="music_head">
                <td>{{ __('Play') }}</td>
                <td>{{ __('Name') }}</td>
                <td>{{ __('Duration') }}</td>
            </tr>
            <?php for ($i = 1; $i < $counter; $i++): ?>
            <tr>
                <td>
                    <input onclick="buttonSong()" type="button" value="<?= $i ?>">
                </td>
                <td id="<?= $i ?>">
                    <?= $songs[$i]['track_name'] ?>
                </td>
                <td>
                    <?= $songs[$i]['duration'] ?>
                </td>
            </tr>
            <?php endfor; ?>
        </table>

        @section('plyr.js')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.7.8/plyr.min.js"></script>
        @endsection

        @section('plyr.css')
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.7.8/plyr.min.css">
        @endsection

        @section('js')
            <script>
                const player=new Plyr("#player");var arrayWithSongsName=[];for(let i=0;i<<?= $counter ?>;i++)arrayWithSongsName[i]=document.getElementById(i);var counter=<?= $_COOKIE['idSong'] ?>,nowPlay="Now playing: ";buttonSong=function(){counter=event.target.value,document.getElementsByClassName("now_play")[0].textContent=nowPlay+arrayWithSongsName[counter].innerText,document.getElementsByClassName("player")[0].src="../storage/app/UsersMusic/<?= Auth::user()->name ?>/"+arrayWithSongsName[counter].innerText,document.cookie="idSong="+counter},(changeSong=document.getElementById("player")).onended=function(){counter++,document.getElementsByClassName("now_play")[0].textContent=nowPlay+arrayWithSongsName[counter].innerText,document.getElementsByClassName("player")[0].src="../storage/app/UsersMusic/<?= Auth::user()->name ?>/"+arrayWithSongsName[counter].innerText,document.cookie="idSong="+counter},next=function(){counter++,document.getElementsByClassName("now_play")[0].textContent=nowPlay+arrayWithSongsName[counter].innerText,document.getElementsByClassName("player")[0].src="../storage/app/UsersMusic/<?= Auth::user()->name ?>/"+arrayWithSongsName[counter].innerText,document.cookie="idSong="+counter},past=function(){counter--,document.getElementsByClassName("now_play")[0].textContent=nowPlay+arrayWithSongsName[counter].innerText,document.getElementsByClassName("player")[0].src="../storage/app/UsersMusic/<?= Auth::user()->name ?>/"+arrayWithSongsName[counter].innerText,document.cookie="idSong="+counter};
            </script>
        @endsection
    @endauth
@endsection
