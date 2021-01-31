@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="title py-5">{{ __('Drivers Manager') }}</h1>


        @if(Session::has('message'))

<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
<br><br>
@endif
<a class="btn btn-primary pull-right" href="{{route('admin.drivers.create',  [app()->getLocale()]) }}"><i class="fa fa-plus"></i> Add New Driver</a> <br><br>
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
                @foreach ($drivers as $driver)
                   
                        <tr>
                            <th scope="row">{{ $driver->id }}</th>
                            <td>{{ $driver->name }}</td>
                            <td>{{ $driver->phone_number }}</td>
                            <td>
                                <div class="d-flex justify-content-start" style="justify-content: space-evenly !important;">
                                   
                                  
                                    <a href="{{ route('admin.drivers.edit', $driver->id, [app()->getLocale()]) }}"
                                        class="btn btn-success">{{ __('Modify Driver') }}
                                    </a>
                                    
                                    <form action="{{ route('admin.drivers.block' ,  $driver->id ,  [app()->getLocale()]) }}"
                                        method="POST" class="mx-2">
                                       	@if ($driver->is_active)
                                        <button type="submit" onclick="return confirm('{{ __('Are you sure you want to block this driver?') }}'); " class="btn btn-danger">{{ __('Block') }}</button>
                                        @else
                                        {{ __('Blocked') }}
                                        @endif
                                        @csrf
                                    </form>
                                    
                                    <form action="{{ route('admin.drivers.delete' ,  $driver->id ,  [app()->getLocale()]) }}"
                                        method="POST" class="mx-2">
                                        @method("DELETE")
                                        <button type="submit" onclick="return confirm('{{ __('Are you sure you want to delete this driver?') }}'); " class="btn btn-danger">{{ __('Delete') }}</button>
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
