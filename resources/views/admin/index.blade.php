@extends('layouts.app')

@section('content')

    <div class="container">

        <h1 class="title py-5">{{__('Welcome')}}</h1>

    <div>
		<canvas id="lineChart" width="450" height="225" class="chartjs-render-monitor"
style="display: block; width: 650px; height: 225px;"></canvas>
    </div>
</div>
<script>
@php
    // last 12 months..
    $labels = [];
	$data = [];
    for($i=0; $i < 12; $i++)
    {
        $labels[] = date("M",strtotime("-{$i} Months"));
        $total = \DB::select("select sum(price) as summ from orders where status='finished' and created_at between '".date("Y-m-1", strtotime("-{$i} Months"))."' and '".date("Y-m-".cal_days_in_month(CAL_GREGORIAN, date("m",strtotime("-{$i} Months")), date("Y",strtotime("-{$i} Months"))), strtotime("-{$i} Months"))."'");
        $data[] = $total[0]->summ == null ? 0 : (int)$total[0]->summ;
    }

    $data = json_encode($data);
    $labels = json_encode($labels);
@endphp


$(document).ready( function () {
	   var data = <?= $data ?>;
	   //var data = JSON.parse(datax);

	   var ctxL = document.getElementById("lineChart").getContext('2d');
	   var myLineChart = new Chart(ctxL, {
	   type: 'line',
	   data: {
	   labels: <?= $labels ?>,
	   datasets: [{
	   label: "Orders",
	   data: data,
	   backgroundColor: [
	   'rgba(105, 0, 132, .2)',
	   ],
	   borderColor: [
	   'rgba(200, 99, 132, .7)',
	   ],
	   borderWidth: 2
	   },


	   ]
	   },
	   options: {
	   responsive: true
	   }
	   });

} );

</script>
@endsection
