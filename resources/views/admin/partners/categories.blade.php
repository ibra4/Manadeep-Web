@extends('layouts.app')

@section('content')

    <div class="container">
        @if(Session::has('message'))
    <br><br><br><br>
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ __(Session::get('message')) }}</p>
@endif
        <h1 class="title py-5">{{ __('Falcon Types') }}</h1>
        <br>
        <div class="pull-right"><a id="addNew" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addNewModal"><i class="fa fa-plus"></i> {{ __('Add New') }}</a></div><br><br>
        <div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <strong>{{ __('Add New') }}</strong>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>

                </div>
                <div class="modal-body" id="mediumBody">
                    <div>
                       <form action="{{ route('admin.partners.add_new_category', [app()->getLocale()]) }}" method="post">
                       <input type="hidden" name="_token" value="{{csrf_token()}}">
                       
                       		<table class="table">

                       			<tr>
                       				<td>{{ __('English Name') }}</td><td><input type="text" name="name_en" class="form-control" required="required"></td>
                       			</tr>
								<tr>
                       				<td>{{ __('Arabic Name') }}</td><td><input type="text" name="name_ar"  class="form-control" required="required"></td>
                       			</tr>
                       			<tr>
                       				<td colspan="2" ><input type="submit" name="submit" value="Add" class="btn btn-sm btn-success pull-right"></td>
                       			</tr>

                       		</table>

                       </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <table class="table table-stdiped">
            <thead>

                <th>{{ __('English Name') }}</th>
                 <th>{{ __('Arabic Name') }}</th>
                <th>{{ __('Actions') }}</th>
            </thead>

            <body>
                @foreach ($type as $item)
                    <tr>

                      <td>
                        	{{$item->name_en}}
                        </td>

                        <td>
                        	{{$item->name_ar}}
                        </td>

                        <td>
                        	<button  class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editModal" aria-data="{{$item->id}}" onclick="load_data({{$item->id}}, '{{$item->name_ar}}', '{{$item->name_en}}')"><i class="fa fa-edit"></i> {{ __('Edit') }}</button>
                        	<button  class="btn btn-sm btn-danger" onclick="deleteit({{$item->id}});"><i class="fa fa-trash"></i> {{ __('Delete') }}</button>
                        </td>

                    </tr>
                @endforeach
            </body>
        </table>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <strong>Edit Data</strong>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>

                </div>
                <div class="modal-body" id="mediumBody">
                    <div>
                       <form action="{{ route('admin.partners.modify_category', [app()->getLocale()]) }}" method="post">
                       <input type="hidden" name="_token" value="{{csrf_token()}}">
                      
                       <input type="hidden" name="id" id="id">
                       		<table class="table">

                       			<tr>
                       				<td>English Name</td><td><input type="text" name="name_en" id="name_en" class="form-control" required="required"></td>
                       			</tr>
								<tr>
                       				<td>Arabic Name</td><td><input type="text" name="name_ar" id="name_ar"  class="form-control" required="required"></td>
                       			</tr>
                       			<tr>
                       				<td colspan="2" ><input type="submit" name="submit" value="Save" class="btn btn-sm btn-success pull-right"></td>
                       			</tr>

                       		</table>

                       </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
	function load_data(id, ar, en)
	{
		$('#id').val(id);
		$('#name_ar').val(ar);
		$('#name_en').val(en);
	}

	function deleteit(id)
	{
		if(confirm('{{ __('Are you sure you want to delete this record?')}}' ))
		{
			window.location.href = "/admin/partners/managecategories/delete/" + id;
		}
	}

</script>
@endsection

