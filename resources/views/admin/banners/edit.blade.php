@extends('layouts.app')

@section('content')

    <div class="container">
        <h1 class="title py-5">{{ __('Editing Banner') }} {{$banner->name}}</h1>

              @if(Session::has('message'))
<br>
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
<br><br>
@endif

        <form action="{{ route('admin.banners.edit', $banner->id, [app()->getLocale() ]) }}" method="POST" enctype="multipart/form-data" class="user-form">

            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{$banner->name}}" required autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="Description">{{ __('Description') }}</label>
                <input id="Description" type="text" class="form-control @error('Description') is-invalid @enderror" name="name"
                value="{{$banner->Description}}" required autofocus>
                @error('Description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


            <div class="form-group">
                <label >{{ __('Current Image') }}</label><br>
				<image src="{{str_replace('/var/www/html','',$banner->image)}}" style="max-width:350px; max-height:200px;" >

            </div>



             <div class="form-group">
                <label for="image">{{ __('Replace Image') }}</label>

                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror"
                    name="image"  >

                @error('image')
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
