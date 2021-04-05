@php
$target = app()->getLocale() == 'ar' ? 'en/' : 'ar/';
$selected = app()->getLocale();
$currentUrl = str_replace($selected . '/', $target, url()->current());
@endphp
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">

        <a class="navbar-brand font-weight-bold" href="{{ route('admin', [app()->getLocale()]) }}">
            {{ __('Koha')}}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('admin', [app()->getLocale()]) }}">{{ __('Home') }} <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                                                        document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout', app()->getLocale()) }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="btn btn-b-n d-sm-none navbar-toggle-box-collapse d-none d-md-block language-button" href="{{ $currentUrl }}">
                        <span>{{ app()->getLocale() == 'en' ? 'ع' : 'En' }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>