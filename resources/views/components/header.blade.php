@php
// $fixed = url()->current() == route('login', app()->getLocale()) ? '' : ' fixed-top';
$target = app()->getLocale() == 'ar' ? 'en' : 'ar';
$selected = app()->getLocale();
$currentUrl = str_replace($selected, $target, url()->current());
@endphp
<!-- ======= Header/Navbar ======= -->
<nav class="navbar navbar-default navbar-trans navbar-expand-lg fixed-top">
    <div class="container">
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarDefault"
            aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <a class="navbar-brand" href="{{ url('/') . '/' . app()->getLocale() }}">
            <img class="w-100" src="{{ asset('images/logo-final.png') }}" alt="logo" srcset="">
        </a>
        <button type="button" class="btn btn-link nav-search navbar-toggle-box-collapse d-md-none"
            data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-expanded="false">
            <span class="fa fa-search" aria-hidden="true"></span>
        </button>
        <div class="navbar-collapse collapse justify-content-center" id="navbarDefault">
<!--             <ul class="navbar-nav m-auto"> -->
<!--                 <li class="nav-item"> -->
<!--                     <a class="nav-link" -->
<!--                         href="">{{ __('Contact Us') }}</a> -->
<!--                 </li> -->
<!--             </ul> -->

        </div>
    </div>
</nav><!-- End Header/Navbar -->
