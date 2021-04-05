@extends('layouts.app')

@section('content')

    <div class="container">
        <h1 class="title py-5">{{ __('Show') }}  {{ $bid->name }}</h1>
        
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
                       <img src={{$bid->image}} class="img-fluid">
                     </div>
                   </div>
            
                 </div>
            
               </div>
               <div class="col-md-6">
            
                 <h2>{{ $bid->name }}</h2>
                 <p class="mb-3 text-muted text-uppercase small">{{$bid->type}}</p>
                 
                 <p><span class="mr-1"><strong>{{$bid->estimate_price}}  QAR</strong></span></p>
                 <p class="pt-1">{{$bid->Description}}</p>
             <hr>
                 <div class="table-responsive">
                   <table class="table table-sm table-borderless mb-0">
                     <tbody>
                       <tr>
                         <th class="pl-0 w-25" scope="row"><strong>{{ __('Type') }}</strong></th>
                         <td>{{$bid->type}}</td>
                       </tr>
                       <tr>
                         <th class="pl-0 w-25" scope="row"><strong>{{ __('Age') }}</strong></th>
                         <td>{{$bid->Age}} Year</td>
                       </tr>
                       <tr>
                         <th class="pl-0 w-25" scope="row"><strong>{{ __('Gender') }}</strong></th>
                         <td>{{$bid->sex}}</td>
                       </tr>
                       <tr>
                         <th class="pl-0 w-25" scope="row"><strong>{{ __('Initial price') }}</strong></th>
                         <td>{{$bid->estimate_price}} QAR</td>
                       </tr>
                       <tr>
                         <th class="pl-0 w-25" scope="row"><strong>{{ __('Last Bid') }}</strong></th>
                         <td>{{$bid->last_price? $bid->last_price.' QAR':''}} </td>
                       </tr>
                       <tr>
                         <th class="pl-0 w-25" scope="row"><strong>{{ __('Trim of Bid') }}</strong></th>
                         <td>{{$bid->Bid_time}} Days</td>
                       </tr>
                       <tr>
                         <th class="pl-0 w-25" scope="row"><strong>{{ __('Location') }}</strong></th>
                         <td>{{$bid->location}}</td>
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
