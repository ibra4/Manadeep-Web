@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="title py-5">{{ __('Locations Pricing') }}</h1>


        @if(Session::has('message'))

<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
<br><br>
@endif

<h3>Location to Location Pricing:</h3>


<a class="btn btn-primary pull-right" href="{{route('admin.locations.pricing.create',  [app()->getLocale()]) }}"><i class="fa fa-plus"></i> Add New Location Pricing</a> <br><br><br>

        <table id='myTable' class="table table-striped">
            <thead>
                <tr>

                    <th scope="col">{{ __('Location 1') }}</th>
                    <th scope="col">{{ __('Location 2') }}</th>
                    <th scope="col">{{ __('Price') }}</th>
                    <th scope="col">{{ __('Duration') }}</th>

                    <th scope="col">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pricings as $pricing)

                        <tr>

                            <td>{{ $cities[$pricing->city_id_1]['name_en'] }}</td>
                            <td>{{ $cities[$pricing->city_id_2]['name_en'] }}</td>
                            <td>{{ $pricing->price }}</td>
                            <td>{{ $pricing->estimate_time }}</td>

                            <td>
                                <div class="d-flex justify-content-start" style="justify-content: space-evenly !important;">

                                    <a href="{{ route('admin.locations.pricing.edit', $pricing->id,  [app()->getLocale()]) }}"
                                        class="btn btn-success">{{ __('Modify Pricing') }}
                                    </a>
                                    <form action="{{ route('admin.locations.pricing.delete' ,  $pricing->id ,  [app()->getLocale()]) }}"
                                        method="POST" class="mx-2">
                                        @method("DELETE")
                                        <button type="submit" onclick="return confirm('{{ __('Are you sure you want to delete this pricing?') }}'); " class="btn btn-danger">{{ __('Delete') }}</button>
                                        @csrf
                                    </form>
                                </div>
                            </td>
                        </tr>

                @endforeach
            </tbody>
        </table>

<br><br><br><br>

        <h3>Bulk KM Pricing:</h3>


<a class="btn btn-primary pull-right" href="{{route('admin.locations.pricing.createbulk',  [app()->getLocale()]) }}"><i class="fa fa-plus"></i> Add New Bulk KM Pricing</a> <br><br><br>

        <table  class="table table-striped">
            <thead>
                <tr>

                    <th scope="col">{{ __('Starting Meters') }}</th>
                    <th scope="col">{{ __('Ending Meters') }}</th>
                    <th scope="col">{{ __('Price') }}</th>

                    <th scope="col">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bulk_pricing as $bulk_price)

                        <tr>

                            <td>{{ $bulk_price->m_start }}</td>
                            <td>{{ $bulk_price->m_end }}</td>
                            <td>{{ $bulk_price->price }}</td>

                            <td>
                                <div class="d-flex justify-content-start" style="justify-content: space-evenly !important;">

                                    <a href="{{ route('admin.locations.pricing.editbulk', $bulk_price->id,  [app()->getLocale()]) }}"
                                        class="btn btn-success">{{ __('Modify Pricing') }}
                                    </a>
                                    <form action="{{ route('admin.locations.pricing.deletebulk' ,  $bulk_price->id ,  [app()->getLocale()]) }}"
                                        method="POST" class="mx-2">
                                        @method("DELETE")
                                        <button type="submit" onclick="return confirm('{{ __('Are you sure you want to delete this pricing?') }}'); " class="btn btn-danger">{{ __('Delete') }}</button>
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
