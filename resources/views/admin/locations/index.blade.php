@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="title py-5">{{ __('Locations Manager') }}</h1>


        @if(Session::has('message'))

<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
<br><br>
@endif

<a class="btn btn-warning pull-left" href="{{route('admin.locations.pricing',  [app()->getLocale()]) }}"><i class="fa fa-list"></i> Manage Location Pricing</a>
<a class="btn btn-primary pull-right" href="{{route('admin.locations.create',  [app()->getLocale()]) }}"><i class="fa fa-plus"></i> Add New Location</a> <br><br>

        <table id='myTable' class="table table-striped">
            <thead>
                <tr>

                    <th scope="col">{{ __('Arabic Name') }}</th>
                    <th scope="col">{{ __('English Name') }}</th>
                    <th scope="col">{{ __('Longitude') }}</th>
                    <th scope="col">{{ __('Latitude') }}</th>
                    <th scope="col">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($locations as $location)

                        <tr>

                            <td>{{ $location->name_ar }}</td>
                            <td>{{ $location->name_en }}</td>
                            <td>{{ $location->lng }}</td>
                            <td>{{ $location->lat }}</td>
                            <td>
                                <div class="d-flex justify-content-start" style="justify-content: space-evenly !important;">

                                    <a href="{{ route('admin.locations.edit', $location->id,  [app()->getLocale()]) }}"
                                        class="btn btn-success">{{ __('Modify Location') }}
                                    </a>
                                    <form action="{{ route('admin.locations.delete' ,  $location->id ,  [app()->getLocale()]) }}"
                                        method="POST" class="mx-2">
                                        @method("DELETE")
                                        <button type="submit" onclick="return confirm('{{ __('Are you sure you want to delete this location?') }}'); " class="btn btn-danger">{{ __('Delete') }}</button>
                                        @csrf
                                    </form>
                                </div>
                            </td>
                        </tr>

                @endforeach
            </tbody>
        </table>
    </div>
@endsection
