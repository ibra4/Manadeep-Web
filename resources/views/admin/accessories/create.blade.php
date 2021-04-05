@extends('layouts.app')

@section('content')

    <div class="container">
        <h1 class="title py-5">{{ __('Add new Accessorie') }}</h1>
        
              @if(Session::has('message'))
<br>
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
<br><br>
@endif

        <form enctype='multipart/form-data' action="{{ route('admin.accessories.create', [app()->getLocale() ]) }}" method="POST" class="user-form">

            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>

                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    required autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
             <div class="form-group">
                <label for="price">{{ __('Price') }}</label>

                <input id="price" type="number" class="form-control @error('price') is-invalid @enderror"
                    name="price" required >

                @error('price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
			<div class="form-group">
                <label for="location">{{ __('Choose a location') }}</label>
				 <select name="location" id="location" class="form-control @error('location') is-invalid @enderror">
                         @foreach ($cite as $cite)
                        	<option value="{{$cite->id}}">{{$cite->name_en}}</option>
                         @endforeach
                 </select>
                @error('location')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="status">{{ __('Choose a Status') }}</label>
				<select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                         <option value="new">{{ __('New') }}</option>
                         <option value="used">{{ __('Used') }}</option>
                         Used
                 </select>
                @error('status')
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
                <textarea class="form-control" name="Description" id="Description" rows="3"></textarea>
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
