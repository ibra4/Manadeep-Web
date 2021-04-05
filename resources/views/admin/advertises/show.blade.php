@extends('layouts.app')

@section('content')

    <div class="container">
        <h1 class="title py-5">{{ __('Show') }}  {{ $Advertise->name }}</h1>
        
    @if(Session::has('message'))
		<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
	@endif
           <!--Section: Block Content-->
            <section class="mb-5">
            
             <div class="row">
               <div class="col-md-6 mb-4 mb-md-0">
            
                 <div id="mdb-lightbox-ui"></div>
            
                 <div class="mdb-lightbox">
            
                   <div class="row product-gallery mx-1">
            
                     <div class="col-12 mb-0">
                       <img src={{$Advertise->image}} class="img-fluid">
                     </div>
                   </div>
            
                 </div>
            
               </div>
               <div class="col-md-6">
            
                 <h2>{{ $Advertise->name }}</h2>
                 <p class="mb-3 text-muted text-uppercase small">{{$Advertise->type}}</p>
                 <p><span class="mr-1"><strong>{{$Advertise->price}}  QAR</strong></span></p>
                 <p class="pt-1">{{$Advertise->Description}}</p>
             <hr>
                 <div class="table-responsive">
                   <table class="table table-sm table-borderless mb-0">
                     <tbody>
                       <tr>
                         <th class="pl-0 w-25" scope="row"><strong>{{ __('Type') }}</strong></th>
                         <td>{{$Advertise->type}}</td>
                       </tr>
                       <tr>
                         <th class="pl-0 w-25" scope="row"><strong>{{ __('Age') }}</strong></th>
                         <td>{{$Advertise->Age}}</td>
                       </tr>
                       <tr>
                         <th class="pl-0 w-25" scope="row"><strong>{{ __('Price') }}</strong></th>
                         <td>{{$Advertise->price}} QAR</td>
                       </tr>
                       <tr>
                         <th class="pl-0 w-25" scope="row"><strong>{{ __('Location') }}</strong></th>
                         <td>{{$Advertise->location}}</td>
                       </tr>
                     </tbody>
                   </table>
                 </div>
               </div>
             </div>
            
            </section>
        <!--Section: Block Content-->
	@csrf
    </div>
@endsection
