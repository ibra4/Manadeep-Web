@extends('layouts.app')

@section('content')
    <div class="container">
    
           @if(Session::has('message'))
<br>
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
<br><br>
@endif
  
        <h1 class="title py-5">{{ __('Drivers Manager') }}</h1>
 <br>
    <div class="row">
    	<div class="col-lg-5">
    		<div class="alert alert-primary">
    		<strong>Profit Settings</strong><br>
    		<form action="{{ route('admin.drivers.updatepercentage') }}" method="POST">
    		@method("PUT")
    			<div class="row">
    				<div class="col-lg-6 pull-left">
    				 Drivers Profit Percentage: 
    				</div>
    				<div class="col-lg-3 pull-right	">
    				 <input type="text" name="profit_percentage" class="form-control " style="font-size:18px;" value="{{ $commission->commission_value * 100 }}">
    				</div>
    				<div class="col-lg-3 pull-left">
    				 <span style="font-size:18px;">%  <input type="submit" class="btn btn-success btn-sm" value="Save"> </span>  
    				</div>
    				
    			</div>
    			@csrf
    		</form>
    		
    		</div> 
    	</div>
    	<div class="col-lg-2"></div>
    	
    	<div class="col-lg-5">
    		<div class="alert alert-primary">
    		<strong>Profits Listings</strong><br>
    			<table class="table table-striped">
    				<tr>
    					<th>Total All Drivers Income</th><td class="pull-right">{{ number_format($drivers_com->summ,2) }}</td>
    				</tr>
    				
    				<tr>
    					<th>Total All Drivers Profits</th><td class="pull-right">{{ number_format($total_profits['drivers'],2) }}</td>
    				</tr>
    				
    				<tr>
    					<th>Total Manadeep Company Profits</th><td class="pull-right">{{ number_format($total_profits['manadeep'],2) }}</td>
    				</tr>
    			
    			
    			
    			</table>
    				
    			
    		
    		
    		</div> 
    	</div>
    	
    </div><br>


<a class="btn btn-primary pull-right" href="{{route('admin.drivers.create',  [app()->getLocale()]) }}"><i class="fa fa-plus"></i> Add New Driver</a> <br><br>
        <table id='myTable' class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#{{ __('ID') }}</th>
                    <th scope="col">{{ __('Name') }}</th>
                    <th scope="col">{{ __('Phone Number') }}</th>
                    <th scope="col">{{ __('Custom Percentage') }}</th>
                    <th scope="col">{{ __("Today's Income") }}</th>
                    <th scope="col">{{ __('Orders') }}</th>
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
                            <form action="{{ route('admin.drivers.updatecomm' ,  $driver->id ,  [app()->getLocale()]) }}"
                                        method="POST" class="mx-2">
                                        @method("PUT")
                                        <input type="hidden" name="driver_id" value="{{$driver->id}}">
                                       
                                        	
                                        	@if ($driver->driver_custom_commission != "")
                                        	
                                        		<input type="text" name="driver_custom_commission" style="width:60px; display:inline;" class="form-control" value="{{ $driver->driver_custom_commission * 100 }}" >%
                                        	@else
                                        		<input type="text" name="driver_custom_commission" style="width:60px; display:inline;" class="form-control"  >%
                                        	@endif
                                        	
                                        	<input type="submit" value="Save" class="btn btn-primary btn-sm" >
                                        
                                       
                                        @csrf
                                    </form>
                            
                            </td>
                            <td>
                            	{{ number_format($driver->todays_income,2) }}
                            </td>
                            <td>
                            	<input type="button" class="btn btn-warning mediumButton" data-attr="{{route('admin.drivers.orders', $driver->id ) }}" value="View Orders"  >
                            </td>
                            <td>
                                <div class="d-flex justify-content-start" style="justify-content: space-evenly !important;">
                                   
                                  
                                    <a href="{{ route('admin.drivers.edit', $driver->id, [app()->getLocale()]) }}"
                                        class="btn btn-success">{{ __('Modify Driver') }}
                                    </a>
                                    
                                    <form action="{{ route('admin.drivers.block' ,  $driver->id ,  [app()->getLocale()]) }}"
                                        method="POST" class="mx-2">
                                         @method("PUT")
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
