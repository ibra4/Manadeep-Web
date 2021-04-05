@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-10">
                <h1 class="title py-5">{{ __('Accessories Manager') }}</h1>
            </div>
            <div class="col-2 float-right" >
                <a href="{{ route('admin.accessories.add', [app()->getLocale()]) }}" class="new-bid">
    					Add Accessories
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
                    <th scope="col">{{ __('Name') }}</th>
                    <th scope="col">{{ __('Price') }}</th>
                    <th scope="col">{{ __('Image') }}</th>
                    <th scope="col">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Accessories as $Accessories)
                        <tr>
                            <th scope="row">{{ $Accessories->id }}</th>
                            <td>{{ $Accessories->name }}</td>
                            <td>{{ $Accessories->price }} QAR</td>
                            <td><img  width="150" height="100" src={{$Accessories->image}}></td>
                         	 <td>
                                <div class="d-flex justify-content-start" style="justify-content: space-evenly !important;">
                                     <a href="{{ route('admin.accessories.show', $Accessories->id, [app()->getLocale()]) }}" class="btn btn-success">
										<i class="fa fa-2x fa-eye"></i>
                                    </a>
                                      <a href="{{ route('admin.accessories.edit', $Accessories->id, [app()->getLocale()]) }}" class="btn btn-success">
										<i class="fa fa-2x fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.accessories.destroy' ,  $Accessories->id,  [app()->getLocale()]) }}" method="POST" class="mx-2">
                                        @method("DELETE")
                                        <button type="submit" onclick="return confirm('{{ __('Are you sure you want to delete this Accessories ?') }}'); " class="btn btn-danger"><i class="fa fa-2x fa-trash"></i></button>
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
