<?php

namespace App\Helpers;

use App\Enums\Role;
use App\Models\Admin;
use App\Models\AdminNotification;
use App\Models\User;
use App\Models\UserNotification;

class NotificationHelper
{
    public static function withdrawalRequested(int $userId, float $amount): void
    {
        $user = User::find($userId);
        if (! $user) {
            return;
        }

        $title = 'Withdrawal Requested';
        $message = "{$user->name} requested a withdrawal of XAF ".number_format($amount).'.';

        self::notifyAdmins($title, $message, 'withdrawal', [
            'user_id' => $userId,
            'amount' => $amount,
            'type' => 'withdrawal_requested',
        ]);
    }

    public static function withdrawalApproved(int $userId, float $amount, ?string $note = null): void
    {
        UserNotification::create([
            'user_id' => $userId,
            'type' => 'withdrawal',
            'title' => 'Withdrawal Approved',
            'message' => 'Your withdrawal of XAF '.number_format($amount)
                .' has been approved and funds have been released.'
                .($note ? " Note: {$note}" : ''),
            'data' => [
                'amount' => $amount,
                'type' => 'withdrawal_approved',
            ],
        ]);
    }

    public static function withdrawalRejected(int $userId, float $amount, ?string $reason = null): void
    {
        UserNotification::create([
            'user_id' => $userId,
            'type' => 'withdrawal',
            'title' => 'Withdrawal Rejected',
            'message' => 'Your withdrawal request of XAF '.number_format($amount)
                .' has been rejected.'
                .($reason ? " Reason: {$reason}" : ''),
            'data' => [
                'amount' => $amount,
                'reason' => $reason,
                'type' => 'withdrawal_rejected',
            ],
        ]);
    }

    public static function notifyAdmins(string $title, string $message, string $type = 'system', array $data = []): void
    {
        $admins = User::where('role', Role::Superadmin->value)->get();
        foreach ($admins as $admin) {
            UserNotification::create([
                'user_id' => $admin->id,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'data' => $data,
            ]);
        }

        $webAdmins = Admin::all();
        foreach ($webAdmins as $admin) {
            AdminNotification::create([
                'admin_id' => $admin->id,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'data' => $data,
            ]);
        }
    }

    public static function adminNotify(int $adminId, string $title, string $message, string $type = 'system', array $data = []): void
    {
        AdminNotification::create([
            'admin_id' => $adminId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
        ]);
    }
}
