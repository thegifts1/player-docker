<header>
    <nav>
        <a href="{{ route('music.index') }}" class="logo">{{ __('Music') }}</a>
        <a href="{{ route('addMusic.index') }}">{{ __('Add Music') }}</a>
    </nav>
    <nav>
        @guest
            @if (Cache::get($_SERVER['REMOTE_ADDR'] . '-darkTheme') == 1)
                <form action="{{ route('settings.changeThemeNotAuth') }}" method="POST">
                    @csrf
                    <input class="themeButton" type="submit" name="lightTheme" value="{{ __('Use light theme') }}">
                </form>
            @else
                <form action="{{ route('settings.changeThemeNotAuth') }}" method="POST">
                    @csrf
                    <input class="themeButton" type="submit" name="darkTheme" value="{{ __('Use dark theme') }}">
                </form>
            @endif

            <div class="dropdown">
                <button onclick="LangDropdown()" class="drop_btn_lang">{{ __('Lang') }}</button>
                <div id="LangDropdown" class="dropdown_content">
                    <form action="{{ route('settings.changeLangNotAuth') }}" method="POST">
                        @csrf
                        <input class="langButton" type="submit" name="lang" value="{{ __('Rus') }}">
                    </form>
                    <form action="{{ route('settings.changeLangNotAuth') }}" method="POST">
                        @csrf
                        <input class="langButton" type="submit" name="lang" value="{{ __('Eng') }}">
                    </form>
                </div>
            </div>
            <a href="{{ route('register.index') }}">{{ __('Registration') }}</a>
            <a href="{{ route('login.index') }}">{{ __('Login') }}</a>
        @endguest
        @auth
            <div class="dropdown">
                <button onclick="NameDropdown()" class="drop_btn_name">{{ Auth::user()->name }}</button>
                <div id="NameDropdown" class="dropdown_content">
                    <a href="{{ route('settings.index') }}">{{ __('Settings') }}</a>
                    <a href="{{ route('logout.store') }}">{{ __('Logout') }}</a>
                </div>
            </div>
        @endauth
        <a id="header_home" href="{{ route('home.index') }}">{{ __('Home') }}</a>
    </nav>
</header>

@section('js.header')
    @guest
        <script>
            function LangDropdown(){document.getElementById("LangDropdown").classList.toggle("show")}window.onclick=function(n){if(!n.target.matches(".drop_btn_lang")){document.getElementsByClassName("dropdown_content");document.getElementById("LangDropdown").classList.remove("show")}};
        </script>
    @endguest
    @auth
        <script>
            function NameDropdown(){document.getElementById("NameDropdown").classList.toggle("show")}window.onclick=function(e){if(!e.target.matches(".drop_btn_name")){document.getElementsByClassName("dropdown_content");document.getElementById("NameDropdown").classList.remove("show")}};
        </script>
    @endauth
@endsection
