<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Str;

class SellerController extends Controller
{
    private function getOrCreateStore()
    {
        $user = auth()->user();
        $store = $user->store;

        if (!$store) {
            $store = Store::create([
                'user_id' => $user->id,
                'name' => $user->name . "'s Store",
                'slug' => Str::slug($user->name . ' store') . '-' . Str::random(5),
                'whatsapp_number' => $user->phone ?? '000000000',
            ]);
        }

        return $store;
    }

    public function dashboard()
    {
        $store = $this->getOrCreateStore();
        $products = $store->products()->with(['images', 'specifications', 'category'])->get();
        $categories = \App\Models\Category::all();
        $user = auth()->user();
        return view('seller.dashboard', compact('store', 'products', 'categories', 'user'));
    }

    public function storeSettings()
    {
        $store = $this->getOrCreateStore();
        return view('seller.store-settings', compact('store'));
    }

    public function updateStoreSettings(Request $request)
    {
        $store = $this->getOrCreateStore();

        $request->validate([
            'name' => 'required|string|max:255',
            'user_name' => 'required|string|max:255',
            'whatsapp_number' => 'required|string|max:20',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:1024',
            'banner' => 'nullable|image|max:2048',
            'profile_photo' => 'nullable|image|max:1024',
        ]);

        $data = $request->only(['name', 'whatsapp_number', 'location', 'description']);
        $user = auth()->user();
        $user->name = $request->user_name;

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('stores/logos', 'public');
        }

        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('stores/banners', 'public');
        }

        if ($request->hasFile('profile_photo')) {
            $user->profile_photo_path = $request->file('profile_photo')->store('profile_photos', 'public');
        }
        
        $user->save();

        $store->update($data);

        return back()->with('success', 'Store settings updated successfully!');
    }
}
