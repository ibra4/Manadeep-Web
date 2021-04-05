@extends('layouts.app')

@section('content')

    <div class="container">
        <h1 class="title py-5">{{ __('Modify') }}  {{ $Accessorie->name }}</h1>
        
              @if(Session::has('message'))
<br>
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
<br><br>
@endif

        <form action="{{ route('admin.accessories.update', $Accessorie->id, 	[app()->getLocale() ]) }}" method="POST" class="user-form">

            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>

                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{$Accessorie->name}}" required autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
             <div class="form-group">
                <label for="price">{{ __('Price') }}</label>

                <input id="price" type="text" class="form-control @error('price') is-invalid @enderror"
                    name="price" value="{{$Accessorie->price}}" required >

                @error('price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="Location">{{ __('Location') }}</label>

                 <input id="location" type="text" class="form-control @error('location') is-invalid @enderror"
                    name="location" value="{{$Accessorie->location}}" required >

                @error('location')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="status">{{ __('Status') }}</label>

                <input id="status" type="text" class="form-control @error('status') is-invalid @enderror"
                    name="status" value="{{$Accessorie->status}}"  >

                @error('status')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="Description"><b>Description</b></label>
                <input id="Description" type="text" class="form-control @error('status') is-invalid @enderror"
                    name="Description" value="{{$Accessorie->Description}}">
            </div>  
    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
	 <div class="form-group mb-3">
	 </div>
	@csrf
    </form>
    </div>
@endsection
