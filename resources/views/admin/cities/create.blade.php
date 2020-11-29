@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h1>Cities</h1>
        <div class="pt-3">
            <form action="{{ route('cities.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="">{{ __('Name AR') }}</label>
                    <input name="name_ar" id="name_ar" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">{{ __('Name EN') }}</label>
                    <input name="name_en" id="name_en" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">{{ __('Latitude') }}</label>
                    <input name="lat" id="lat" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">{{ __('Longitue') }}</label>
                    <input name="lng" id="lng" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ __('Add') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
