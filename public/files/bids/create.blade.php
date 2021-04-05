@extends('layouts.app')

@section('content')

    <div class="container">
        <h1 class="title py-5">{{ __('Add new bid') }}</h1>
        
              @if(Session::has('message'))
<br>
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
<br><br>
@endif

        <form enctype='multipart/form-data' action="{{ route('admin.bids.create', [app()->getLocale() ]) }}" method="POST" class="user-form">

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
                <label for="estimate_price">{{ __('Initial price') }}</label>

                <input id="estimate_price" type="number" class="form-control @error('estimate_price') is-invalid @enderror"
                    name="estimate_price" required >

                @error('estimate_price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="Bid_time">{{ __('Term of bid') }}</label>

                <input id="Bid_time" type="number" class="form-control @error('Bid_time') is-invalid @enderror"
                    name="Bid_time" required >

                @error('Bid_time')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>            

            <div class="form-group">
                <label for="Age">{{ __('Age') }}</label>
                 <input id="Age" type="number" class="form-control @error('Age') is-invalid @enderror"
                    name="Age" required >

                @error('Age')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


			<div class="form-group">
                <label for="location">{{ __('Choose a location') }}</label>
				 <select name="location" id="location" class="form-control @error('location') is-invalid @enderror">
                         @foreach ($cite as $cite)
                        	<option value="{{$cite->name_en}}">{{$cite->name_en}}</option>
                         @endforeach
                 </select>
                @error('location')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            
             <div class="form-group">
                <label for="type">{{ __('Choose a Type') }}</label>
				<select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                         @foreach ($type as $type)
                        	<option value="{{$type->name_en}}">{{$type->name_en}}</option>
                        @endforeach
                 </select>
                @error('type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
      			  <input type="radio" id="age1" name="sex" value="male">
                  <label for="age1">{{ __('Mail') }}</label><br>
                  <input type="radio" id="age2" name="sex" value="female">
                  <label for="age2">{{ __('Femail') }}</label><br>  
                @error('sex')
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
