<nav class="navbar navbar-expand-md navbar-light navbar-laravel border-dark border-bottom" style="box-shadow: 10px 10px 10px rgba(0, 0, 0, 0.5);margin-bottom:20px;">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown" id="markasread" onclick="markNotificationAsRead({{count(auth()->user()->unreadNotifications)}})">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle"  href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Maps
                        </a>

                        <div class="dropdown-menu dropdown-menu-right border border-dark" aria-labelledby="navbarDropdown">

                            <a class="dropdown-item" href="{{route('map.index')}}">Maps</a>

                            <a class="dropdown-item" href="{{route('map.create')}}">Create own map</a>

                        </div>
                    </li>
                    <li class="nav-item dropdown" id="markasread" onclick="markNotificationAsRead({{count(auth()->user()->unreadNotifications)}})">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle"  href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Notifications <span class="badge">{{count(auth()->user()->unreadNotifications)}}</span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right border border-dark" aria-labelledby="navbarDropdown">

                            @forelse(auth()->user()->unreadNotifications as $notification)
                                @include('layouts.partials.notification.'.snake_case(class_basename($notification->type)))
                            @empty
                                <a class="dropdown-item" href="#">No unread Notifications</a>
                            @endforelse

                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right border border-dark" aria-labelledby="navbarDropdown">

                            <a class="dropdown-item" href="{{ route('user_profile',auth()->user()) }}">
                                My Profile
                            </a>

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
            </ul>
        </div>
    </div>
</nav>