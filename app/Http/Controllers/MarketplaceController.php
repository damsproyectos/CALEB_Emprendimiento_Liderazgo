<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function products()
    {
        $products = Product::with(['store', 'category', 'images'])
            ->where('status', 'active')
            ->latest()
            ->get()
            ->map(function ($product) {
                $imagePath = $product->image;
                if ($imagePath) {
                    if (!str_starts_with($imagePath, 'http') && !str_starts_with($imagePath, '/')) {
                        $imagePath = '/storage/' . $imagePath;
                    }
                } else {
                    $imagePath = 'https://images.unsplash.com/photo-1560343090-f0409e92791a?auto=format&fit=crop&w=500&q=80';
                }

                $gallery = $product->images->map(function ($img) {
                    return str_starts_with($img->image_path, 'http') || str_starts_with($img->image_path, '/')
                        ? $img->image_path
                        : '/storage/' . $img->image_path;
                })->toArray();

                return [
                    'id' => $product->id,
                    'company' => $product->store ? $product->store->name : 'Emprendimiento Caleb',
                    'service' => $product->name,
                    'commercial_price' => (float) ($product->commercial_price ?? $product->price),
                    'caleb' => (float) $product->price,
                    'address' => $product->store ? ($product->store->address ?? $product->store->phone ?? 'Pereira') : 'Pereira',
                    'image' => $imagePath,
                    'images' => $gallery,
                    'categoryId' => $product->category_id ?? 1,
                    'description' => $product->description ?? '',
                ];
            });

        return response()->json($products);
    }

    public function categories()
    {
        $categories = Category::all()->map(function ($cat) {
            return [
                'id' => $cat->id,
                'name' => $cat->name,
                'description' => $cat->name,
            ];
        });

        return response()->json($categories);
    }
}
