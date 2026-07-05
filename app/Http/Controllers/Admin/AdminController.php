<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Service;
use App\Models\RentalItem;
use App\Models\Order;
use App\Models\ServiceBooking;
use App\Models\RentalTransaction;
use App\Models\WalletTransaction;
use App\Models\Withdrawal;
use App\Models\AdvertisementRequest;

class AdminController extends Controller
{
    public function dashboard()
    {
        $metrics = [
            'total_users' => User::count(),
            'total_stores' => Store::count(),
            'total_products' => Product::count(),
            'total_services' => Service::count(),
            'total_rentals' => RentalItem::count(),
            'total_orders' => Order::count(),
            'total_bookings' => ServiceBooking::count(),
            'total_rental_transactions' => RentalTransaction::count(),
            'pending_verifications' => Store::where('is_verified', false)->count(),
            'pending_ads' => AdvertisementRequest::where('status', 'pending')->count(),
            'pending_withdrawals' => Withdrawal::where('status', 'pending')->count(),
            'pending_products' => Product::where('approval_status', 'pending')->count(),
            'pending_services' => Service::where('approval_status', 'pending')->count(),
            'total_reports' => \App\Models\ProductReport::count() + \App\Models\StoreReport::count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('total_amount'),
        ];

        $recentStores = Store::with('user')->latest()->take(5)->get();
        $recentProducts = Product::with(['store', 'mainImage', 'images'])->latest()->take(5)->get();
        $recentAds = AdvertisementRequest::with('store')->latest()->take(5)->get();
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // Dynamic Chart Data (Last 6 Months)
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $chartData[] = [
                'label' => $month->format('M'),
                'users' => User::whereMonth('created_at', $month->month)->whereYear('created_at', $month->year)->count(),
                'stores' => Store::whereMonth('created_at', $month->month)->whereYear('created_at', $month->year)->count(),
                'orders' => Order::whereMonth('created_at', $month->month)->whereYear('created_at', $month->year)->count(),
            ];
        }

        $pendingWithdrawalsCount = $metrics['pending_withdrawals'];
        $pendingWithdrawalsAmount = Withdrawal::where('status', 'pending')->sum('amount');

        return view('admin.dashboard', compact(
            'metrics', 'recentStores', 'recentProducts', 'recentAds',
            'recentOrders', 'chartData', 'pendingWithdrawalsCount', 'pendingWithdrawalsAmount'
        ));
    }

    public function analytics()
    {
        $metrics = [
            'total_users' => User::count(),
            'total_stores' => Store::count(),
            'total_products' => Product::count(),
            'total_services' => Service::count(),
            'total_rentals' => RentalItem::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('total_amount'),
            'active_ads' => AdvertisementRequest::where('status', 'approved')->where('ends_at', '>', now())->count(),
        ];

        // Monthly Growth
        $growth = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $growth[] = [
                'month' => $date->format('M'),
                'users' => User::whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->count(),
                'stores' => Store::whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->count(),
                'products' => Product::whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->count(),
                'orders' => Order::whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->count(),
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

        AuditLogger::log('settings.updated', 'System settings updated');

        return back()->with('success', 'System settings updated successfully.');
    }

    public function profile()
    {
        $admin = auth()->guard('admin')->user();
        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = auth()->guard('admin')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->id,
        ]);

        $oldValues = $admin->only(['name', 'email']);
        $admin->update($validated);
        $newValues = $admin->only(['name', 'email']);

        AuditLogger::log('profile.updated', 'Admin profile updated', null, $oldValues, $newValues, $admin);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin = auth()->guard('admin')->user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $admin->update(['password' => Hash::make($request->password)]);

        AuditLogger::log('profile.password_changed', 'Admin password changed', null, null, null, $admin);

        return back()->with('success', 'Password updated successfully.');
    }
}
