@extends('layouts.app')

@section('content')
    <div class="container">
    
           @if(Session::has('message'))
<br>
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
<br><br>
@endif
  
        <h1 class="title py-5">{{ __('Partners Manager') }}</h1>
 <br>
  


<a class="btn btn-warning pull-left" href="{{route('admin.partners.managecategories',  [app()->getLocale()]) }}"><i class="fa fa-list"></i> Manage Partners Categories</a>
<a class="btn btn-primary pull-right" href="{{route('admin.partners.create',  [app()->getLocale()]) }}"><i class="fa fa-plus"></i> Add New Partner</a>  
<br><br><br>
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
                @foreach ($cite as $cite)
                   
                        <tr>
                            <th scope="row">{{ $cite->id }}</th>
                            <td>{{ $cite->name_en }}</td>
                            <td>{{ $cite->name_en }}</td>
                            <td>
                                <div class="d-flex justify-content-start" style="justify-content: space-evenly !important;">
                                   
                                  
                                    <a href="{{ route('admin.partners.edit', $cite->id, [app()->getLocale()]) }}"
                                        class="btn btn-success">{{ __('Modify Partner') }}
                                    </a>
                                    <form action="{{ route('admin.partners.delete' ,  $cite->id ,  [app()->getLocale()]) }}"
                                        method="POST" class="mx-2">
                                        @method("DELETE")
                                        <button type="submit" onclick="return confirm('{{ __('Are you sure you want to delete this partner?') }}'); " class="btn btn-danger">{{ __('Delete') }}</button>
                                        @csrf
                                    </form>
                                    
                                    
                                    
                                </div>
                            </td>
                        </tr>
                  
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade " id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="mediumBody" >
                    <div>
                        <!-- the result to be displayed apply here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
		

		jQuery(document).ready(function(){
			jQuery(document).on('click', '.mediumButton', function(event) {
                event.preventDefault();
                let href = jQuery(this).attr('data-attr');
                jQuery.ajax({
                    url: href,
                    beforeSend: function() {
                        jQuery('#loader').show();
                    },
                    // return the result
                    success: function(result) {
                        jQuery('#mediumModal').modal("show");
                        jQuery('#mediumBody').html(result).show();
                    },
                    complete: function() {
                        jQuery('#loader').hide();
                    },
                    error: function(jqXHR, testStatus, error) {
                        console.log(error);
                        alert("Page " + href + " cannot open. Error:" + error);
                        jQuery('#loader').hide();
                    },
                    timeout: 8000
                })
            });
		});

    </script>
@endsection
