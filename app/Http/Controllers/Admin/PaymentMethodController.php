<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $methods = PaymentMethod::latest()->get();
        return view('admin.settings.payment-methods.index', compact('methods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'icon' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'number', 'account_name']);
        
        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('payment_icons', 'r2');
        }

        $method = PaymentMethod::create($data);

        AuditLogger::log('payment_method.created', "Created payment method #{$method->id}: {$method->name}", $method);

        return back()->with('success', 'Payment method added successfully.');
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'icon' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'number', 'account_name']);
        
        if ($request->hasFile('icon')) {
            if ($paymentMethod->icon) {
                Storage::disk('r2')->delete($paymentMethod->icon);
            }
            $data['icon'] = $request->file('icon')->store('payment_icons', 'r2');
        }

        $oldValues = $paymentMethod->only(['name', 'number', 'account_name']);
        $paymentMethod->update($data);
        $newValues = $paymentMethod->only(['name', 'number', 'account_name']);

        AuditLogger::log('payment_method.updated', "Updated payment method #{$paymentMethod->id}: {$paymentMethod->name}", $paymentMethod, $oldValues, $newValues);

        return back()->with('success', 'Payment method updated successfully.');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        if ($paymentMethod->icon) {
            Storage::disk('r2')->delete($paymentMethod->icon);
        }
        $paymentMethod->delete();
        AuditLogger::log('payment_method.deleted', "Deleted payment method #{$paymentMethod->id}: {$paymentMethod->name}");
        return back()->with('success', 'Payment method deleted.');
    }

    public function toggle(PaymentMethod $paymentMethod)
    {
        $oldStatus = $paymentMethod->is_active;
        $paymentMethod->update(['is_active' => !$paymentMethod->is_active]);

        AuditLogger::log('payment_method.toggled', "Toggled payment method #{$paymentMethod->id}: {$paymentMethod->name} active=" . ($paymentMethod->is_active ? 'yes' : 'no'), $paymentMethod, ['is_active' => $oldStatus], ['is_active' => $paymentMethod->is_active]);

        return back()->with('success', 'Status updated.');
    }
}
