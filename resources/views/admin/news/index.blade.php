@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-10">
                <h1 class="title py-5">{{ __('News Manager') }}</h1>
            </div>
            <div class="col-2 float-right" >
                <a href="{{ route('admin.news.add', [app()->getLocale()]) }}" class="new-bid">
    					Add News
                </a>
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
                    <th scope="col">{{ __('Title') }}</th>
                    <th scope="col">{{ __('Description') }}</th>
                    <th scope="col">{{ __('Image') }}</th>
                    <th scope="col">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($News as $News)
                        <tr>
                            <th scope="row">{{ $News->id }}</th>
                            <td>{{ $News->title }}</td>
                            <td>{{ $News->description }}</td>
                            <td><img  width="150" height="100" src={{$News->image}}></td>
                         	 <td>
                                <div class="d-flex justify-content-start" style="justify-content: space-evenly !important;">
                                    <form action="{{ route('admin.news.destroy' ,  $News->id,  [app()->getLocale()]) }}" method="POST" class="mx-2">
                                        @method("DELETE")
                                        <button type="submit" onclick="return confirm('{{ __('Are you sure you want to delete this News ?') }}'); " class="btn btn-danger"><i class="fa fa-2x fa-trash"></i></button>
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
