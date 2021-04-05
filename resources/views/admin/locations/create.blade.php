@extends('layouts.app')

@section('content')

    <div class="container">
        <h1 class="title py-5">{{ __('Create New Location') }} </h1>

              @if(Session::has('message'))
<br>
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
<br><br>
@endif

        <form action="{{ route('admin.locations.create', [app()->getLocale() ]) }}" method="POST" class="user-form">

            <div class="form-group">
                <label for="name_ar">{{ __('Arabic Name') }}</label>

                <input id="name_ar" type="text" class="form-control @error('name_ar') is-invalid @enderror" name="name_ar"
                    value="" required autofocus>

                @error('name_ar')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


             <div class="form-group">
                <label for="name_ar">{{ __('English Name') }}</label>

                <input id="name_en" type="text" class="form-control @error('name_en') is-invalid @enderror" name="name_en"
                    value="" required >

                @error('name_en')
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
