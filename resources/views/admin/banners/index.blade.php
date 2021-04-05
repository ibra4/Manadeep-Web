@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="title py-5">{{ __('Banners Manager') }}</h1>


        @if(Session::has('message'))

<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
<br><br>
@endif

<div class="pull-right"><a id="addNew" class="btn btn-sm btn-primary" href="{{route('admin.banners.create') }}" ><i class="fa fa-plus"></i> {{ __('Add New') }}</a></div><br><br>
        <table id='myTable' class="table table-striped">
            <thead>
                <tr>
                    
                    <th scope="col">{{ __('Name') }}</th>
                    <th scope="col">{{ __('Image') }}</th>
                    <th scope="col">{{ __('Description') }}</th>
                    <th scope="col">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($banners as $banner)
                        <tr>
                           
                            <td>{{ $banner->name }}</td>
                            <td><img src="{{ $banner->image }}" style="width: 200px; height:130px;" ></td>
                            <td>{{ $banner->Description }}</td>
                            <td>
                                <div class="d-flex justify-content-start" style="justify-content: space-evenly !important;">
                                    <a href="{{ route('admin.banners.edit' , $banner->id, [app()->getLocale()]) }}"
                                        class="btn btn-warning">{{ __('Edit Banner') }}
                                    </a>
                                   
                                    <form action="{{ route('admin.banners.delete' ,  $banner->id ,  [app()->getLocale()]) }}"
                                        method="POST" class="mx-2">
                                        @method("DELETE")
                                        <button type="submit" onclick="return confirm('{{ __('Are you sure you want to delete this banner?') }}'); " class="btn btn-danger">{{ __('Delete') }}</button>
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
