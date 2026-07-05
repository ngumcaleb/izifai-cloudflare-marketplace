<?php

namespace App\Helpers;

use App\Models\Admin;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AuditLogger
{
    public static function log(
        string $action,
        string $description,
        ?Model $subject = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        Admin|User|null $actor = null,
    ): AuditLog {
        $adminId = null;
        $userId = null;

        if ($actor instanceof Admin) {
            $adminId = $actor->id;
        } elseif ($actor instanceof User) {
            $userId = $actor->id;
        } elseif (auth('admin')->check()) {
            $adminId = auth('admin')->id();
        } elseif (auth()->check()) {
            $userId = auth()->id();
        }

        return AuditLog::create([
            'admin_id' => $adminId,
            'user_id' => $userId,
            'action' => $action,
            'entity_type' => $subject ? get_class($subject) : null,
            'entity_id' => $subject?->getKey(),
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
