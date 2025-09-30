<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'MedCharity') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('About') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('Contact') }}">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('LoginDonator') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('RegisterDonator') }}">Register</a>
                    </li>
                @else
                    @if(Auth::guard('admin')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/admin/dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/admin/users') }}">Manage Users</a>
                        </li>
                    @elseif(Auth::guard('manager')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/ngo/manager') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('DisplayPickupmen') }}">Manage Pickupmen</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('DisplayVerifier') }}">Manage Verifiers</a>
                        </li>
                    @elseif(Auth::guard('pickupman')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/ngo/pickupman') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('ViewPDs-Pickupman') }}">Pending Donations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('ViewTDs-Pickupman') }}">Taken Donations</a>
                        </li>
                    @elseif(Auth::guard('verifier')->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/ngo/verifier') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('ViewPDs-Verifier') }}">Pending Donations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('ViewTD-Verifier') }}">Taken Donations</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/donate') }}">Donate</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('viewDonations-Donator') }}">My Donations</a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ url('/profile') }}">Profile</a>
                            <a class="dropdown-item" href="{{ url('/changepassword') }}">Change Password</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('/logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
