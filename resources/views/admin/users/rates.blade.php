@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="title py-5">{{ __('Orders Reviews for ') }} {{ __($user->name) }}</h1>



        <table id='myTable' class="table table-striped">
            <thead>
                <tr>
                	<th scope="col">{{ __('Order #') }}</th>
                	<th scope="col">{{ __('Date') }}</th>
                    <th scope="col">{{ __('From') }}</th>
                    <th scope="col">{{ __('To') }}</th>


                    <th scope="col">{{ __('Service') }}</th>
                    <th scope="col">{{ __('Response') }}</th>
                    <th scope="col">{{ __('Driver') }}</th>
                    <th scope="col">{{ __('Quality') }}</th>
                    <th scope="col">{{ __('Performance') }}</th>
                    <th scope="col">{{ __('App Style') }}</th>
                    <th scope="col">{{ __('Price') }}</th>
                    <th scope="col">{{ __('Comments') }}</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($rates as $rate)

                   <tr>
                	<td scope="col">{{ $rate->id }}</td>
                	<td scope="col">{{ date("d/m/Y", strtotime($rate->created_at)) }}</td>
                    <td scope="col">{{ $rate->fromName }}</td>
                    <td scope="col">{{ $rate->toName }}</td>


                    <td scope="col">{{ $rate->service }}/5</td>
                    <td scope="col">{{ $rate->response }}/5</td>
                    <td scope="col">{{ $rate->driver }}/5</td>
                    <td scope="col">{{ $rate->quality }}/5</td>
                    <td scope="col">{{ $rate->performance }}/5</td>
                    <td scope="col">{{ $rate->app_style }}/5</td>
                    <td scope="col">{{ $rate->price }}/5</td>
                    <td scope="col">{{ $rate->comments }}</td>

                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
@endsection
