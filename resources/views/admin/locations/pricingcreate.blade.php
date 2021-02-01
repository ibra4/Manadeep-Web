@extends('layouts.app')

@section('content')

    <div class="container">
        <h1 class="title py-5">{{ __('Create New Location Pricing') }} </h1>

              @if(Session::has('message'))
<br>
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
<br><br>
@endif

        <form action="{{ route('admin.locations.pricing.create', [app()->getLocale() ]) }}" method="POST" class="user-form">

            <div class="form-group">
                <label for="location1">{{ __('Location 1') }}</label>


                    <select id="location1"  class="form-control @error('location1') is-invalid @enderror" name="location1"
                     required autofocus>
                     	<option>Select Location 1</option>
                     	@foreach($locations as $location)
                     		<option value="{{$location->id}}" >{{$location->name_en}}</option>
                     	@endforeach
                     </select>

                @error('location1')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


             <div class="form-group">
                <label for="location2">{{ __('Location 2') }}</label>


 				<select id="location2"  class="form-control @error('location2') is-invalid @enderror" name="location2"
                     required autofocus>
                     	<option>Select Location 2</option>
                     	@foreach($locations as $location)
                     		<option value="{{$location->id}}" >{{$location->name_en}}</option>
                     	@endforeach
                     </select>

                @error('location2')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>





             <div class="form-group">
                <label for="price">{{ __('Price') }}</label>

                <input id="price" type="text" class="form-control @error('price') is-invalid @enderror"
                    name="price" required >

                @error('price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>









    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

	@csrf
    </form>
    </div>
@endsection
