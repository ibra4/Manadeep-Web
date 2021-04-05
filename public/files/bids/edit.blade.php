@extends('layouts.app')

@section('content')

    <div class="container">
        <h1 class="title py-5">{{ __('Modify bid') }}  {{ $bid->name }}</h1>
        
              @if(Session::has('message'))
<br>
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
<br><br>
@endif

        <form action="{{ route('admin.bids.edit', $bid->id, 	[app()->getLocale() ]) }}" method="POST" class="user-form">

            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>

                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{$bid->name}}" required autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
             <div class="form-group">
                <label for="phone_number">{{ __('Initial price') }}</label>

                <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror"
                    name="phone_number" value="{{$bid->estimate_price}}" required >

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
             <div class="form-group">
                <label for="phone_number">{{ __('Last Bid') }}</label>

                <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror"
                    name="phone_number" value="{{$bid->last_price}}" required >

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>             <div class="form-group">
                <label for="phone_number">{{ __('Trim of Bid') }}</label>

                <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror"
                    name="phone_number" value="{{$bid->Bid_time}}" required >

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>            

            <div class="form-group">
                <label for="password">{{ __('Age') }}</label>

                 <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror"
                    name="phone_number" value="{{$bid->Age}}" required >

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


			<div class="form-group">
                <label for="password2">{{ __('Location') }}</label>

                 <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror"
                    name="phone_number" value="{{$bid->location}}" required >

                @error('password2')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="email">{{ __('Sex') }}</label>

                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{$bid->sex}}"  >

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
                        <div class="form-group">
                <label for="email">{{ __('Type') }}</label>

                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{$bid->type}}"  >

                @error('email')
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
