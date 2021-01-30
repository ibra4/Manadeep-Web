@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="title py-5">{{ __('Users Manager') }}</h1>
        <table id='myTable' class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#{{ __('ID') }}</th>
                    <th scope="col">{{ __('Name') }}</th>
                    <th scope="col">{{ __('Phone Number') }}</th>
                    <th scope="col">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    @if (($user->id == 1 && auth()->user()->id == 1) || $user->id != 1)
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->phone_number }}</td>
                            <td>
                                <div class="d-flex justify-content-start" style="justify-content: space-evenly !important;">
                                    <a href="{{ route('admin.users.orders/$user->id', [app()->getLocale()]) }}"
                                        class="btn btn-warning">{{ __('Orders') }}
                                    </a>
                                    <a href="{{ route('admin.users.edit', [app()->getLocale(), $user->id]) }}"
                                        class="btn btn-primary">{{ __('Rates') }}
                                    </a>
                                    <a href="{{ route('admin.users.edit', [app()->getLocale(), $user->id]) }}"
                                        class="btn btn-success">{{ __('Edit') }}
                                    </a>
                                    <form action="{{ route('admin.users.destroy', [app()->getLocale(), $user]) }}"
                                        method="POST" class="mx-2">
                                        @method("DELETE")
                                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                        @csrf
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
