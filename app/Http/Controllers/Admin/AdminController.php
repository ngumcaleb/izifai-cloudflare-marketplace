<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Store;
use App\Models\Product;

class AdminController extends Controller
{
    public function dashboard()
    {
        $metrics = [
            'total_users' => User::count(),
            'total_stores' => Store::count(),
            'total_products' => Product::count(),
            'pending_verifications' => Store::where('is_verified', false)->count(),
            'pending_ads' => \App\Models\AdvertisementRequest::where('status', 'pending')->count(),
            'total_reports' => \App\Models\ProductReport::count(),
        ];

        $recentStores = Store::with('user')->latest()->take(5)->get();
        $recentProducts = Product::with(['store', 'mainImage', 'images'])->latest()->take(5)->get();
        $recentAds = \App\Models\AdvertisementRequest::with(['product', 'store'])->latest()->take(5)->get();

        // Dynamic Chart Data (Last 6 Months)
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $chartData[] = [
                'label' => $month->format('M'),
                'users' => User::whereMonth('created_at', $month->month)->whereYear('created_at', $month->year)->count(),
                'stores' => Store::whereMonth('created_at', $month->month)->whereYear('created_at', $month->year)->count(),
            ];
        }

        return view('admin.dashboard', compact('metrics', 'recentStores', 'recentProducts', 'recentAds', 'chartData'));
    }

    public function analytics()
    {
        $metrics = [
            'total_users' => User::count(),
            'total_stores' => Store::count(),
            'total_products' => Product::count(),
            'active_ads' => \App\Models\AdvertisementRequest::where('status', 'approved')->where('ends_at', '>', now())->count(),
        ];

        // Monthly Growth
        $growth = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $growth[] = [
                'month' => $date->format('M'),
                'users' => User::whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->count(),
                'stores' => Store::whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->count(),
            ];
        }

        return view('admin.analytics', compact('metrics', 'growth'));
    }

    public function settings()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->except('_token');
        $fileKeys = ['hero_image', 'default_store_logo', 'default_store_banner'];

        if ($request->hasFile('hero_image')) {
            $path = $request->file('hero_image')->store('hero', 'r2');
            \App\Models\Setting::set('hero_image', $path);
        }

        if ($request->hasFile('default_store_logo')) {
            $request->file('default_store_logo')->storeAs('', 'default-logo.jpg', 'r2');
            \App\Models\Setting::set('default_logo_version', now()->timestamp);
        }

        if ($request->hasFile('default_store_banner')) {
            $request->file('default_store_banner')->storeAs('', 'default-banner.jpg', 'r2');
            \App\Models\Setting::set('default_banner_version', now()->timestamp);
        }

        foreach ($data as $key => $value) {
            if (in_array($key, $fileKeys)) continue;
            \App\Models\Setting::set($key, $value);
        }

        return back()->with('success', 'System settings updated successfully.');
    }
}
