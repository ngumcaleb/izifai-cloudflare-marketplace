<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\SupportReport;
use App\Helpers\NotificationHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SupportController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category' => 'required|string|in:bug,payment,order,store,account,content,other',
            'description' => 'required|string|min:20|max:5000',
            'email' => 'nullable|email|max:255',
            'order_number' => 'nullable|string|max:50',
        ]);

        $report = SupportReport::create([
            'user_id' => auth()->id(),
            'category' => $validated['category'],
            'description' => $validated['description'],
            'email' => $validated['email'] ?? $request->user()?->email,
            'order_number' => $validated['order_number'] ?? null,
            'status' => 'open',
        ]);

        // Notify admins
        $categoryLabels = [
            'bug' => 'Bug or Technical Issue',
            'payment' => 'Payment Problem',
            'order' => 'Order Issue',
            'store' => 'Store or Seller Issue',
            'account' => 'Account Problem',
            'content' => 'Inappropriate Content',
            'other' => 'Other',
        ];

        NotificationHelper::notifyAdmins(
            'New Support Report',
            sprintf(
                '[%s] %s',
                $categoryLabels[$validated['category']] ?? $validated['category'],
                Str::limit($validated['description'], 100)
            ),
            'support',
            [
                'report_id' => $report->id,
                'category' => $validated['category'],
                'user_id' => auth()->id(),
                'user_name' => $request->user()?->name,
            ]
        );

        return response()->json([
            'message' => 'Report submitted successfully. Our team will review it within 24 hours.',
            'report' => $report,
        ], 201);
    }
}
