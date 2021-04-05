@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-10">
                <h1 class="title py-5">{{ __('Advertises Manager') }}</h1>
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
                    <th scope="col">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Advertises as $Advertise)
                        <tr>
                            <th scope="row">{{ $Advertise->id }}</th>
                            <td>{{ $Advertise->name }}</td>
                            <td>{{ $Advertise->price }} QAR</td>
                            <td><img  width="150" height="100" src={{$Advertise->image}}></td>
                         	 <td>
                                    @if($Advertise->approve != '1')
                                    <a href="{{ route('admin.advertises.approve', $Advertise->id, [app()->getLocale()]) }}"
                                        class="btn btn-success">{{ __('Approve Advertise') }}
                                    </a>
                                    @endif
                                    @if($Advertise->approve == '1')
                                    <p
                                        class="">{{ __('Approved') }}
                                    </p>
                                    @endif
							</td>
                         	 <td>
                                <div class="d-flex justify-content-start" style="justify-content: space-evenly !important;">
                                     <a href="{{ route('admin.advertises.show', $Advertise->id, [app()->getLocale()]) }}" class="btn btn-success">
										<i class="fa fa-2x fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.advertises.destroy' ,  $Advertise->id,  [app()->getLocale()]) }}" method="POST" class="mx-2">
                                        @method("DELETE")
                                        <button type="submit" onclick="return confirm('{{ __('Are you sure you want to delete this Advertise ?') }}'); " class="btn btn-danger"><i class="fa fa-2x fa-trash"></i></button>
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
