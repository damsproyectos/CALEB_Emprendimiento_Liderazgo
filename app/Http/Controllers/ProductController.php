<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $store = $user->store;

        $products = [];
        if ($store) {
            $products = Product::where('store_id', $store->id)
                ->with('category')
                ->latest()
                ->get();
        }

        $categories = Category::select('id', 'name')->get();

        return Inertia::render('Products/Index', [
            'store' => $store,
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            return redirect()->back()->withErrors(['store' => 'Debes crear tu perfil de tienda antes de publicar productos.']);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'commercial_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'status' => 'required|in:active,draft,out_of_stock',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'store_id' => $store->id,
            'category_id' => $validated['category_id'] ?? null,
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . Str::random(5),
            'description' => $validated['description'] ?? null,
            'commercial_price' => $validated['commercial_price'] ?? null,
            'price' => $validated['price'],
            'image' => $imagePath,
            'status' => $validated['status'],
        ]);

        return redirect()->back()->with('success', 'Producto creado exitosamente.');
    }

    public function update(Request $request, Product $product)
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store || $product->store_id !== $store->id) {
            abort(403, 'No tienes permiso para modificar este producto.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'commercial_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'status' => 'required|in:active,draft,out_of_stock',
        ]);

        $data = [
            'category_id' => $validated['category_id'] ?? null,
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'commercial_price' => $validated['commercial_price'] ?? null,
            'price' => $validated['price'],
            'status' => $validated['status'],
        ];

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->back()->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Product $product)
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store || $product->store_id !== $store->id) {
            abort(403, 'No tienes permiso para eliminar este producto.');
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->back()->with('success', 'Producto eliminado exitosamente.');
    }
}
