@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Cities</h1>
            <a href="{{ route('cities.create') }}">
                <h4>{{ __('Add new city') }}</h4>
            </a>
        </div>
        <div class="pt-3">
            <table class="table">
                <thead>
                    <th>{{ __('ID#') }}</th>
                    <th>{{ __('AR Name') }}</th>
                    <th>{{ __('EN Name') }}</th>
                    <th>{{ __('Latitude') }}</th>
                    <th>{{ __('Longitude') }}</th>
                    <th>{{ __('Actions') }}</th>
                </thead>
                <tbody>
                    @foreach ($cities as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name_ar }}</td>
                            <td>{{ $item->name_en }}</td>
                            <td>{{ $item->lat }}</td>
                            <td>{{ $item->lng }}</td>
                            <td>
                                <form action="{{ route('cities.destroy', [$item->id]) }}" method="POST">
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
