@extends('layouts.app')

@section('content')

    <div class="container">
        <h1 class="title py-5">{{ __('Create New Bulk Pricing') }} </h1>

              @if(Session::has('message'))
<br>
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
<br><br>
@endif

        <form action="{{ route('admin.locations.pricing.createbulk', [app()->getLocale() ]) }}" method="POST" class="user-form">

            <div class="form-group">
                <label for="m_start">{{ __('Starting Meters') }}</label>


                    <input id="m_start"  class="form-control @error('m_start') is-invalid @enderror" name="m_start"
                     required autofocus>

                @error('m_start')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

			<div class="form-group">
                <label for="m_end">{{ __('Ending Meters') }}</label>


                    <input id="m_end"  class="form-control @error('m_end') is-invalid @enderror" name="m_end"
                     required autofocus>

                @error('m_end')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>







             <div class="form-group">
                <label for="price">{{ __('Price') }}</label>

                <input id="price" type="text" class="form-control @error('price') is-invalid @enderror"
                    name="price" required >

                @error('price')
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
