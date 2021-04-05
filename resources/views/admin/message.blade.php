@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-10">
                <h1 class="title py-5">{{ __('Messages Manager') }}</h1>
            </div>
        </div>


        @if(Session::has('message'))

<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
<br><br>
@endif
        <table id='myTable' class="table table-striped">
 <table id='myTable' class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#{{ __('ID') }}</th>
                    <th scope="col">{{ __('User Name') }}</th>
                    <th scope="col">{{ __('Message') }}</th>
                    <th scope="col">{{ __('Date') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($messages as $messages)
                        <tr>
                            <th scope="row">{{ $messages->id }}</th>
                            <td>{{ $messages->user_id }}</td>
                            <td>{{ $messages->message}}</td>
                            <td>{{ $messages->created_at}}</td>
                            </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
