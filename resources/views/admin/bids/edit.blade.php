@extends('layouts.app')

@section('content')

    <div class="container">
        <h1 class="title py-5">{{ __('Modify bid') }}  {{ $bid->name }}</h1>

              @if(Session::has('message'))
<br>
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
<br><br>
@endif

        <form action="{{ route('admin.bids.update', $bid->id, 	[app()->getLocale() ]) }}" method="POST" class="user-form">

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
                <label for="estimate_price">{{ __('Initial price') }}</label>

                <input id="estimate_price" type="text" class="form-control @error('estimate_price') is-invalid @enderror"
                    name="estimate_price" value="{{$bid->estimate_price}}" required >

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
                   <div class="form-group">
                <label for="Bid_time">{{ __('Trim of Bid') }}</label>

                <input id="Bid_time" type="text" class="form-control @error('phone_number') is-invalid @enderror"
                    name="Bid_time" value="{{$bid->Bid_time}}" required >

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

               <div class="form-group">
                <label for="Age">{{ __('Age') }}</label>
                 <select id="Age"  class="form-control @error('Age') is-invalid @enderror"
                    name="Age" required >
                    	<option value="chick" <?php if($bid->Age == "chick") { echo "selected='selected' "; } ?> >Chick</option>
                    	<option value="virgin" <?php if($bid->Age == "virgin") { echo "selected='selected' "; } ?>>Virgin</option>
                    	<option value="second" <?php if($bid->Age == "second") { echo "selected='selected' "; } ?>>Second</option>
                    	<option value="third" <?php if($bid->Age == "third") { echo "selected='selected' "; } ?> >Third</option>
                    	<option value="fourth"<?php if($bid->Age == "fourth") { echo "selected='selected' "; } ?> >Fourth</option>
                    	<option value="fifth_more" <?php if($bid->Age == "fifth_more") { echo "selected='selected' "; } ?> >Fifth or more</option>
                    </select>

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
                        	<option value="{{$cite->id}}" <?php if($bid->location == $cite->id ) { echo "selected='selected' "; }?>>{{$cite->name_en}}</option>
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
                        	<option value="{{$type->id}}" <?php if($bid->location == $type->id ) { echo "selected='selected' "; }?>>{{$type->name_en}}</option>
                        @endforeach
                 </select>
                @error('type')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
      			  <input type="radio" id="age1" name="sex" value="male" <?php if($bid->sex == "male") { echo "checked='checked'"; } ?>>
                  <label for="age1">{{ __('Male') }}</label><br>
                  <input type="radio" id="age2" name="sex" value="female"  <?php if($bid->sex == "female") { echo "checked='checked'"; } ?>>
                  <label for="age2">{{ __('Female') }}</label><br>
                @error('sex')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

             <div class="form-group mb-3">
                <label for="description"><b>Description</b></label>
                <textarea class="form-control" name="Description" id="Description" rows="3">{{$bid->Description}}</textarea>
                <small class="text-danger"></small>
            </div>




    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

	@csrf
    </form>
    </div>
@endsection
