<style>
.smaller-s { font-size:12px; }
</style>
    <div class="smaller-s" >
        <h3 class="title py-5">{{ __('Orders for ') }} {{ __($driver->name) }}</h3>



        <table class="table table-striped">
            <thead>
                <tr>
                	<th scope="col">{{ __('Order #') }}</th>
                	
                	<th scope="col">{{ __('Date') }}</th>
                    <th scope="col">{{ __('From') }}</th>
                    <th scope="col">{{ __('To') }}</th>
                    <th scope="col">{{ __('Status') }}</th>
                
                    <th scope="col">{{ __('Price') }}</th>
                   
                    <th scope="col">{{ __('Receiver Name') }}</th>
                    <th scope="col">{{ __('Receiver Phone') }}</th>
                    <th scope="col">{{ __('Order Comments') }}</th>
                </tr>
            </thead>
            <tbody>
            @php
            $total = 0;
            @endphp
                @foreach ($orders as $order)

                  <tr>
                	<td scope="col">{{ $order->id }}</td>
                	
                	<td scope="col">{{ date("d/m/Y", strtotime($order->created_at)) }}</td>
                    <td scope="col">{{ $order->fromName }}</td>
                    <td scope="col">{{ $order->toName }}</td>
                    <td scope="col">{{ $order->status }}</td>
                   
                    <td scope="col">{{ $order->price }}</td>
                    @php
                    if($order->status == "finished")
                    {
                    $total += $order->price;
                    }
                    @endphp
                    
                    <td scope="col">{{ $order->recieverName }}</td>
                    <td scope="col">{{ $order->recieverPhone }}</td>
                    <td scope="col">{{ $order->comments }}</td>
                </tr>

                @endforeach
                <tr>
            		<td colspan="5" ><strong>Total: </strong></td>
            		<td><strong>{{number_format($total,2) }}</strong></td>
            		<td colspan= "3"></td>
            	</tr>
            </tbody>
           
            
        </table>

</div>