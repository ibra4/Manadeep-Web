<div id="mySidenav" class="sidenav hide">

    <div class="sidemenu-toggler text-center w-100px my-5" onclick="toggleNav()">
        <i class="fa fa-bars fa-2x" style="color: white"></i>
    </div>

    <div class="text-center w-100px my-5">
        <img style="width: 100px; height: 100px" src="{{ asset('images/logo-final.png') }}" alt="logo" srcset="">
    </div>
     <a class="py-4" href="{{ route('admin.users', [app()->getLocale()]) }}"><i
            class="fa fa-2x fa-user w-100px text-center"></i><span>{{ __('Manage Users') }}</span>
     </a>
     <a class="py-4" href="{{ route('admin.bids', [app()->getLocale()]) }}"><i
            class="fa fa-2x fa-gavel w-100px text-center"></i><span>{{ __('Manage Bids') }}</span>
     </a>
     <a class="py-4" href="{{route('admin.partners')}}"><i
            class="fa fa-2x fa-paw w-100px text-center"></i><span>{{ __('Manage Categoris') }}</span>
     </a>
     <a class="py-4" href="{{route('admin.banners')}}"><i
    	class="fa fa-2x fa-list-ul w-100px text-center"></i><span>{{ __('Manage Banners') }}</span>
     </a>
     <a class="py-4" href="{{route('admin.locations')}}"><i
            class="fa fa-location-arrow w-100px text-center"></i><span>{{ __('Manage locations') }}</span>
   	 </a>
   	 <a class="py-4" href="{{route('admin.advertises')}}"><i
            class="fa fa-location-arrow w-100px text-center"></i><span>{{ __('Manage Advertise') }}</span>
   	 </a>
   	 <a class="py-4" href="{{route('admin.accessories')}}"><i
            class="fa fa-location-arrow w-100px text-center"></i><span>{{ __('Manage Accessories') }}</span>
   	 </a>
   	 
   	  <a class="py-4" href="{{route('admin.news')}}"><i
            class="fa fa-location-arrow w-100px text-center"></i><span>{{ __('Manage News App') }}</span>
   	 </a>
   	 <a class="py-4" href="{{route('admin.contact')}}"><i
            class="fa fa-location-arrow w-100px text-center"></i><span>{{ __('Manage Contact Form') }}</span>
   	 </a>
   	 <a class="py-4" href="{{route('admin.messages')}}"><i
        class="fa fa-location-arrow w-100px text-center"></i><span>{{ __('Manage Message Admin') }}</span>
   	 </a>
   </div>
