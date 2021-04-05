@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-10">
                <h1 class="title py-5">{{ __('Contacts Manager') }}</h1>
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
                    <th scope="col">{{ __('Name') }}</th>
                    <th scope="col">{{ __('Email') }}</th>
                    <th scope="col">{{ __('Subject') }}</th>
                    <th scope="col">{{ __('Message') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Contact as $Contact)
                        <tr>
                            <th scope="row">{{ $Contact->id }}</th>
                            <td>{{ $Contact->name }}</td>
                            <td>{{ $Contact->email }}</td>
                            <td>{{$Contact->subject}}</td>
                            <td>{{ $Contact->message}}</td>
                            </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
