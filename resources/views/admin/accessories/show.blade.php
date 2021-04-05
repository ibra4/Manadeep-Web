@extends('layouts.app')

@section('content')

    <div class="container">
        <h1 class="title py-5">{{ __('Show') }}  {{ $Accessorie->name }}</h1>
        
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
                       <img src={{$Accessorie->image}} class="img-fluid">
                     </div>
                   </div>
            
                 </div>
            
               </div>
               <div class="col-md-6">
            
                 <h2>{{ $Accessorie->name }}</h2>
                 <p><span class="mr-1"><strong>{{$Accessorie->price}}  QAR</strong></span></p>
                 <p class="pt-1">{{$Accessorie->Description}}</p>
             <hr>
                 <div class="table-responsive">
                   <table class="table table-sm table-borderless mb-0">
                     <tbody>
                       <tr>
                         <th class="pl-0 w-25" scope="row"><strong>{{ __('Status') }}</strong></th>
                         <td>{{$Accessorie->status}}</td>
                       </tr>
                       <tr>
                         <th class="pl-0 w-25" scope="row"><strong>{{ __('Price') }}</strong></th>
                         <td>{{$Accessorie->price}} QAR</td>
                       </tr>
                       <tr>
                         <th class="pl-0 w-25" scope="row"><strong>{{ __('Location') }}</strong></th>
                         <td>{{$Accessorie->location}}</td>
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
