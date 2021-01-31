@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="title py-5">{{ __('Orders for ') }} {{ __($user->name) }}</h1>



        <table id='myTable' class="table table-striped">
            <thead>
                <tr>
                	<th scope="col">{{ __('Order #') }}</th>
                	<th scope="col">{{ __('Driver') }}</th>
                	<th scope="col">{{ __('Date') }}</th>
                    <th scope="col">{{ __('From') }}</th>
                    <th scope="col">{{ __('To') }}</th>
                    <th scope="col">{{ __('Status') }}</th>
                    <th scope="col">{{ __('Cost') }}</th>
                    <th scope="col">{{ __('Price') }}</th>
                    <th scope="col">{{ __('Payer') }}</th>
                    <th scope="col">{{ __('Package Type') }}</th>
                    <th scope="col">{{ __('Receiver Name') }}</th>
                    <th scope="col">{{ __('Receiver Phone') }}</th>
                    <th scope="col">{{ __('Order Comments') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)

                  <tr>
                	<td scope="col">{{ $order->id }}</td>
                	<td scope="col">{{ $order->driver_name }}</td>
                	<td scope="col">{{ date("d/m/Y", strtotime($order->created_at)) }}</td>
                    <td scope="col">{{ $order->fromName }}</td>
                    <td scope="col">{{ $order->toName }}</td>
                    <td scope="col">{{ $order->status }}</td>
                    <td scope="col">{{ $order->cost }}</td>
                    <td scope="col">{{ $order->price }}</td>
                    <td scope="col">{{ $order->payer }}</td>
                    <td scope="col">{{ $order->package }}</td>
                    <td scope="col">{{ $order->recieverName }}</td>
                    <td scope="col">{{ $order->recieverPhone }}</td>
                    <td scope="col">{{ $order->comments }}</td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
@endsection
