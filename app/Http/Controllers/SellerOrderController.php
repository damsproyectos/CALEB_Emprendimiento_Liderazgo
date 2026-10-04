<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SellerOrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $store = $user->store;

        $orders = [];
        if ($store) {
            $orders = Order::where('store_id', $store->id)
                ->with('orderItems')
                ->latest()
                ->get();
        }

        return Inertia::render('Orders/SellerOrders', [
            'store' => $store,
            'orders' => $orders,
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store || $order->store_id !== $store->id) {
            abort(403, 'No tienes permiso para actualizar este pedido.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return redirect()->back()->with('success', "Estado del pedido #{$order->order_number} actualizado a " . strtoupper($validated['status']));
    }
}
