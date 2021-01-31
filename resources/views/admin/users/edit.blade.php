@extends('layouts.app')

@section('content')

    <div class="container">
        <h1 class="title py-5">{{ __('Edit User') }} <b>{{ $user->name }}</b></h1>
        <form action="{{ route('admin.users.update', $user->id, [app()->getLocale() ]) }}" method="POST" class="user-form">

            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>

                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ $user->name }}" required autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">{{ __('Password') }}</label>

                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password"  >

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>



            @if ($user->id != 1)
                <div class="form-group">
                    <label for="roles">{{ __('Roles') }}</label>
                    @foreach ($roles as $role)
                        <div class="form-check">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="form-check-input"
                            @php

                           foreach($user_roles as $userRole)
                            {
                            	if($userRole->role_id == $role->id) { echo "checked='checked'"; }

                            }
                            @endphp
                             />

                    <label for="" class="form-check-label">{{ $role->name }}</label>
                </div>
            @endforeach
    </div>
    @endif
    <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>

	@csrf
    </form>
    </div>
@endsection
