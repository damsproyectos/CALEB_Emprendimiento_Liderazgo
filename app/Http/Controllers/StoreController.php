<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class StoreController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $store = $user->store;

        return Inertia::render('Store/Manage', [
            'store' => $store,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $store = $user->store;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $data = [
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'address' => $validated['address'] ?? null,
            'phone' => $validated['phone'] ?? null,
        ];

        if ($request->hasFile('logo')) {
            if ($store && $store->logo) {
                Storage::disk('public')->delete($store->logo);
            }
            $data['logo'] = $request->file('logo')->store('stores/logos', 'public');
        }

        if ($request->hasFile('banner')) {
            if ($store && $store->banner) {
                Storage::disk('public')->delete($store->banner);
            }
            $data['banner'] = $request->file('banner')->store('stores/banners', 'public');
        }

        if ($store) {
            $store->update($data);
        } else {
            $data['user_id'] = $user->id;
            $store = Store::create($data);
        }

        return redirect()->back()->with('success', 'Perfil de la tienda guardado con éxito.');
    }
}
