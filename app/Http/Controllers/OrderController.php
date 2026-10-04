<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:50',
            'customer_address' => 'nullable|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Group items by store
        $storeGroups = [];
        foreach ($validated['items'] as $item) {
            $product = Product::with('store')->find($item['id']);
            if (!$product) {
                continue;
            }

            $storeId = $product->store_id ?? 1;
            if (!isset($storeGroups[$storeId])) {
                $storeGroups[$storeId] = [
                    'store' => $product->store ?? Store::find(1),
                    'items' => [],
                ];
            }

            $storeGroups[$storeId]['items'][] = [
                'product' => $product,
                'quantity' => $item['quantity'],
                'price' => (float) $product->price,
                'subtotal' => (float) $product->price * $item['quantity'],
            ];
        }

        if (empty($storeGroups)) {
            return response()->json(['error' => 'No se encontraron productos válidos.'], 422);
        }

        $createdOrders = [];

        foreach ($storeGroups as $storeId => $group) {
            $store = $group['store'];
            $items = $group['items'];

            $total = array_sum(array_column($items, 'subtotal'));
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(4));

            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::check() ? Auth::id() : null,
                'store_id' => $storeId,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'] ?? (Auth::check() ? Auth::user()->email : null),
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'total' => $total,
                'status' => 'pending',
            ]);

            $whatsappItemsText = "";
            foreach ($items as $itemData) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $itemData['product']->id,
                    'product_name' => $itemData['product']->name,
                    'price' => $itemData['price'],
                    'quantity' => $itemData['quantity'],
                    'subtotal' => $itemData['subtotal'],
                ]);

                $whatsappItemsText .= "• {$itemData['product']->name} x{$itemData['quantity']} - $" . number_format($itemData['subtotal']) . "\n";
            }

            // Build WhatsApp message for this store
            $storePhone = $store ? ($store->phone ?? '573146494446') : '573146494446';
            $cleanPhone = preg_replace('/[^0-9]/', '', $storePhone);
            if (!str_starts_with($cleanPhone, '57') && strlen($cleanPhone) === 10) {
                $cleanPhone = '57' . $cleanPhone;
            }

            $waMessage = "¡Hola! Realicé un nuevo pedido en el Marketplace Caleb 🛒\n\n";
            $waMessage .= "📌 *Pedido N°:* {$orderNumber}\n";
            $waMessage .= "👤 *Cliente:* {$validated['customer_name']}\n";
            $waMessage .= "📞 *Teléfono:* {$validated['customer_phone']}\n";
            if (!empty($validated['customer_address'])) {
                $waMessage .= "📍 *Dirección:* {$validated['customer_address']}\n";
            }
            $waMessage .= "\n📦 *Productos:*\n{$whatsappItemsText}\n";
            $waMessage .= "💰 *Total a Pagar:* $" . number_format($total) . "\n\n";
            $waMessage .= "¡Quedo atento a la confirmación de mi pedido!";

            $waLink = "https://api.whatsapp.com/send/?phone={$cleanPhone}&text=" . urlencode($waMessage);

            $createdOrders[] = [
                'id' => $order->id,
                'order_number' => $orderNumber,
                'store_name' => $store ? $store->name : 'Emprendimiento Caleb',
                'total' => $total,
                'whatsapp_link' => $waLink,
            ];
        }

        return response()->json([
            'success' => true,
            'message' => '¡Pedido registrado exitosamente!',
            'orders' => $createdOrders,
        ]);
    }
}
