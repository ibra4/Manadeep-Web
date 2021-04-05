@extends('layouts.app')

@section('content')

    <div class="container">
        <h1 class="title py-5">{{ __('Add new Accessorie') }}</h1>
        
              @if(Session::has('message'))
<br>
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
<br><br>
@endif

        <form enctype='multipart/form-data' action="{{ route('admin.news.create', [app()->getLocale() ]) }}" method="POST" class="user-form">

            <div class="form-group">
                <label for="title">{{ __('Title') }}</label>
                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                    required autofocus>

                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="image">{{ __('Upload Image') }}</label>
                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror"
                    name="image"  >

                @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="description"><b>Description</b></label>
                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                <small class="text-danger"></small>
            </div>
			<div class="form-group mb-3">
    			<button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
			</div>
			<div class="form-group mb-3"></div>
	@csrf
    </form>
    </div>
@endsection
