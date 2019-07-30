
<!-- navはnavbar -->
<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            @auth('web')
            履歴書おきば
            @endauth
            @auth('customers')
            ようこそ
            @endauth
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest('web')
                @guest('customers')
                <li class="nav-item">{{ $link1 }}</li>
                <li class="nav-item">{{ $link2 }}</li>
                <li class="nav-item">{{ $link3 }}</li>
                @endguest
                @else

                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                        <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('profile',Auth::user()->name) }}">{{ Auth::user()->name }}のプロファイル</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            @endguest
            @auth('customers')
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::guard('customers')->user()->name }}
                    <span class="caret"></span>
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('customers.profile',Auth::guard('customers')->user()->name) }}">{{ Auth::guard('customers')->user()->name }}のページ</a>
                    <a class="dropdown-item" href="{{ route('customers.logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <!-- csrf用form -->
                <form id="logout-form" action="{{ route('customers.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
        @endauth
        <!-- ul div -->
    </ul>
</div>
</div>
</nav>
