@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="title py-5">{{ __('Users Manager') }}</h1>


        @if(Session::has('message'))

<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
<br><br>
@endif
        <table id='myTable' class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#{{ __('ID') }}</th>
                    <th scope="col">{{ __('Name') }}</th>
                    <th scope="col">{{ __('Phone Number') }}</th>
                    <th scope="col">{{ __('approve') }}</th>
                    <th scope="col">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    @if (($user->id == 1 && auth()->user()->id == 1) || $user->id != 1)
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>
                                    @if($user->active != '1')
                                    <a href="{{ route('admin.users.active', $user->id, [app()->getLocale()]) }}"
                                        class="btn btn-success">{{ __('Approve User') }}
                                    </a>
                                    @endif
                                    @if($user->active == '1')
                                    <p
                                        class="">{{ __('Active') }}
                                    </p>
                                    @endif
							</td>
                            <td>
                                <div class="d-flex justify-content-start" style="justify-content: space-evenly !important;">
                                     <a href="{{ route('admin.users.edit', $user->id, [app()->getLocale()]) }}"
                                        class="btn btn-success">{{ __('Modify User') }}
                                    </a>
                                    <form action="{{ route('admin.users.delete' ,  $user->id ,  [app()->getLocale()]) }}"
                                        method="POST" class="mx-2">
                                        @method("DELETE")
                                        <button type="submit" onclick="return confirm('{{ __('Are you sure you want to delete this user?') }}'); " class="btn btn-danger">{{ __('Delete') }}</button>
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
