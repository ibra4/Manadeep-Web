<div id="mySidenav" class="sidenav hide">

    <div class="sidemenu-toggler text-center w-100px my-5" onclick="toggleNav()">
        <i class="fa fa-bars fa-2x" style="color: white"></i>
    </div>

    <div class="text-center w-100px my-5">
        <img style="width: 100px; height: 120px" src="{{ asset('images/logo-final.png') }}" alt="logo" srcset="">
    </div>
    <a class="py-4" href="{{ route('admin.users', [app()->getLocale()]) }}"><i
            class="fa fa-2x fa-user w-100px text-center"></i><span>{{ __('Manage Users') }}</span></a>
     <a class="py-4" href="{{ route('admin.drivers', [app()->getLocale()]) }}"><i
            class="fa fa-2x fa-id-card w-100px text-center"></i><span>{{ __('Manage Drivers') }}</span></a>
    <a class="py-4" href=""><i
            class="fa fa-2x fa-dollar w-100px text-center"></i><span>{{ __('Drivers accounting') }}</span></a>
    <a class="py-4" href=""><i
    class="fa fa-2x fa-list-ul w-100px text-center"></i><span>{{ __('Manage Orders') }}</span></a>
    <a class="py-4" href=""><i
            class="fa fa-product-hunt w-100px text-center"></i><span>{{ __('Manage_Product') }}</span></a>
   </div>
