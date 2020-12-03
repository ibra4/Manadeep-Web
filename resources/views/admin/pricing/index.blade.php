@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Cities</h1>
            <a href="{{ route('cities-pricing.create') }}">
                <h4>{{ __('Add new Pricing item') }}</h4>
            </a>
        </div>
        <div class="pt-3">
            <table class="table">
                <thead>
                    <th>{{ __('ID#') }}</th>
                    <th>{{ __('City 1') }}</th>
                    <th>{{ __('City 2') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Actions') }}</th>
                </thead>
                <tbody>
                    @foreach ($pricings as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->city1()->name_en }}</td>
                            <td>{{ $item->city2()->name_en }}</td>
                            <td>{{ $item->price }}</td>
                            <td>
                                <form action="{{ route('cities-pricing.destroy', [$item->id]) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger">{{ __('Remove') }}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
