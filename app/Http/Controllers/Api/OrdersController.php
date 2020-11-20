<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends BaseController
{

    public function __construct()
    {
        $this->middleware('can:add-order')->only('add');
        $this->middleware('can:take-order')->only('status');
        $this->middleware('can:manage-website')->only(['getAll']);
    }

    public function getAll(Request $request)
    {
        $orders = Order::all();
        return $this->sendResponse($orders, 'success');
    }

    public function get(Request $request)
    {
        $user_id = auth('api')->user()->id;
        $orders = Order::select('id', 'user_id', 'driver_id', 'created_at', 'fromName', 'toName', 'status')
            ->where('user_id', $user_id)->with([
                'user' => function ($q) {
                    $q->select('id', 'name');
                },
                'driver' => function ($q) {
                    $q->select('id', 'name');
                }
            ])->get();
        return $this->sendResponse($orders, 'success');
    }

    public function getSingle(Request $request, Order $order, $id)
    {
        $user = auth('api')->user();

        $order = $order->newQuery()->with([
            'user' => function ($q) {
                $q->select('id', 'name');
            },
            'driver' => function ($q) {
                $q->select('id', 'name');
            },
            'rate'
        ])->where('id', $id);

        if (!$user->hasRole('admin')) {
            if ($user->hasRole('user')) {
                $order->where('user_id', $user->id);
            } else if ($user->hasRole('driver')) {
                $order->where('driver_id', $user->id);
            }
        }

        return $this->sendResponse($order->get()->first(), 'success');
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
            'payer' => 'required',
            'comments' => 'required',
            'package' => 'required',
        ]);

        $order = new Order();

        $order->from = $request->input('fromLat') . ',' . $request->input('fromLng');
        $order->to = $request->input('toLat') . ',' . $request->input('toLng');
        $order->fromName = $request->input('fromName');
        $order->toName = $request->input('toName');
        $order->cost = $request->input('cost');
        $order->driver_id = null;
        $order->rate_id = null;
        $order->user_id = auth('api')->user()->id;
        $order->status = 'in_propgress';
        $order->payer = $request->input('payer');
        $order->package = $request->input('package');
        $order->comments = $request->input('comments');

        $order->save();

        return $this->sendResponse($order, 'created successfully');
    }

    public function status(Request $request, $id)
    {
        $request->validate([
            'status' => "required|in:canceled,in_propgress,driving,from_reached,finished,manadeep"
        ]);
        $order = Order::find($id);
        $order->driver_id = auth('api')->user()->id;
        $order->status = $request->input('status');
        $order->save();

        return $this->sendResponse($order, 'order taken');
    }
}
