@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h1>Pricing</h1>
        <div class="pt-3">
            <form action="{{ route('cities-pricing.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="">{{ __('City 1') }}</label>
                    <select name="city1" id="city1" class="form-control">
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name_ar }}</option>
                        @endforeach
                    </select>
                    @error('city1')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">{{ __('City 2') }}</label>
                    <select name="city2" id="city2" class="form-control">
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name_ar }}</option>
                        @endforeach
                    </select>
                    @error('city1')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">{{ __('Price') }}</label>
                    <input name="price" id="price" type="text" class="form-control">
                    @error('price')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ __('Add') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
