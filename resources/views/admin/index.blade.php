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
</script>
@endsection
