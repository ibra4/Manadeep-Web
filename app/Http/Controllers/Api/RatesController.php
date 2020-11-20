<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Rate;
use App\Models\Role;
use Illuminate\Http\Request;

class RatesController extends BaseController
{
    public function __construct()
    {
        $this->middleware('can:rate-order', ['only' => 'add']);
        $this->middleware('can:show-rate', ['only' => 'get']);
    }

    public function add(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return $this->sendError('no order with this id', 'error');
        }

        if ($order->user_id != auth('api')->user()->id) {
            return $this->sendError('you cannot rate this order', null, 403);
        }

        if ($order->rate_id != null) {
            return $this->sendError('you cannot rate this order, this order have a rate', null, 400);
        }

        $request->validate([
            'service' => 'required|numeric',
            'response' => 'required|numeric',
            'driver' => 'required|numeric',
            'quality' => 'required|numeric',
            'performance' => 'required|numeric',
            'app_style' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $rate = new Rate();

        $rate->service = $request->input('service');
        $rate->response = $request->input('response');
        $rate->driver = $request->input('driver');
        $rate->quality = $request->input('quality');
        $rate->performance = $request->input('performance');
        $rate->app_style = $request->input('app_style');
        $rate->price = $request->input('price');
        $rate->comments = $request->has('comments') ? $request->input('comments') : null;
        $rate->save();

        $order->rate_id = $rate->id;
        $order->save();

        return $this->sendResponse($rate, 'created successfully');
    }
}
