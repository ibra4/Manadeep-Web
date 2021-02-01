@extends('layouts.app')

@section('content')

    <div class="container">
        <h1 class="title py-5">{{ __('Edit Location') }} {{ $location->name_en }}</h1>

              @if(Session::has('message'))
<br>
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
<br><br>
@endif

        <form action="{{ route('admin.locations.edit', $location->id , [app()->getLocale() ]) }}" method="POST" class="user-form">

            <div class="form-group">
                <label for="name_ar">{{ __('Arabic Name') }}</label>

                <input id="name_ar" type="text" class="form-control @error('name_ar') is-invalid @enderror" name="name_ar"
                    value="{{$location->name_ar}}" required autofocus>

                @error('name_ar')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


             <div class="form-group">
                <label for="name_ar">{{ __('English Name') }}</label>

                <input id="name_en" type="text" class="form-control @error('name_en') is-invalid @enderror" name="name_en"
                    value="{{$location->name_en}}" required >

                @error('name_en')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>





             <div class="form-group">
                <label for="lng">{{ __('Longitude') }}</label>

                <input id="lng" type="text" class="form-control @error('lng') is-invalid @enderror"
                    name="lng" value="{{$location->lng}}" >

                @error('lng')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

             <div class="form-group">
                <label for="lat">{{ __('Latitude') }}</label>

                <input id="lat" type="text" class="form-control @error('lat') is-invalid @enderror"
                    name="lat" value="{{$location->lat}}" >

                @error('lat')
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
