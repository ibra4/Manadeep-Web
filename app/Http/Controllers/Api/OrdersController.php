<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends BaseController
{
    public function getAll(Request $request)
    {
        $orders = Order::all();
        return $this->sendResponse($orders, 'success');
    }

    public function get(Request $request)
    {
        $user_id = auth('api')->user()->id;
        $orders = Order::where('user_id', $user_id)->get();
        return $this->sendResponse($orders, 'success');
    }

    public function add(Request $request)
    {
        $request->validate([
            'fromLat' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'fromLng' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'fromName' => 'required',
            'toLat' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'toLng' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'toName' => 'required',
            'cost' => 'required|numeric',
            'status' => 'required|enum',
            'payer' => 'required',
            'comments' => 'required',
            'package' => 'required',
        ]);

        $order = new Order();

        $order->from = $request->input('fromLat') + ',' + $request->input('fromLng');
        $order->to = $request->input('toLat') + ',' + $request->input('toLng');
        $order->fromName = $request->input('fromName');
        $order->toName = $request->input('toName');
        $order->cost = $request->input('cost');
        $order->driver_id = null;
        $order->user_id = auth('api')->user()->id;
        $order->status = $request->input('status');
        $order->payer = $request->input('payer');
        $order->package = $request->input('package');
        $order->comments = $request->input('comments');

        $order->save();

        return $this->sendResponse($order, 'success');
    }
}
