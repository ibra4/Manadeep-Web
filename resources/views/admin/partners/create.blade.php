@extends('layouts.app')

@section('content')

    <div class="container">
        <h1 class="title py-5">{{ __('Create New Partner') }} </h1>
        
              @if(Session::has('message'))
<br>
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
<br><br>
@endif

        <form action="{{ route('admin.partners.create', [app()->getLocale() ]) }}" method="POST" class="user-form">

            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>

                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="" required autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
             <div class="form-group">
                <label for="phone_number">{{ __('Phone') }}</label>

                <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror"
                    name="phone_number" required >

                @error('phone_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            
             <div class="form-group">
                <label for="partner_sub_package_id">{{ __('Category') }}</label>
                
                
                <select id="partner_sub_package_id" name="partner_sub_package_id" class="form-control @error('partner_sub_package_id') is-invalid @enderror" required>
                	<option>Please Select</option>
                @foreach($partner_categories as $partner_category)
                	
                	<option value="{{ $partner_category->id }}">{{ $partner_category->name_en }}</option>
                
                @endforeach
                
                </select>

                @error('partner_sub_package_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            

            <div class="form-group">
                <label for="password">{{ __('Password') }}</label>

                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required >

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


			<div class="form-group">
                <label for="password2">{{ __('Password Confirmation') }}</label>

                <input id="password2" type="password" class="form-control @error('password2') is-invalid @enderror"
                    name="password2" required >

                @error('password2')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>

                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror"
                    name="email"  >

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
