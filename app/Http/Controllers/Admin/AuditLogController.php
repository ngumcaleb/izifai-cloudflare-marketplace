<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('admin');

        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%");
            });
        }

        if ($request->filled('admin_id')) {
            $query->where('admin_id', $request->admin_id);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('entity_type')) {
            $query->where('entity_type', $request->entity_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 30)
            ->withQueryString();

        $admins = \App\Models\Admin::orderBy('name')->get(['id', 'name']);
        $actions = AuditLog::select('action')->distinct()->orderBy('action')->pluck('action');
        $entityTypes = AuditLog::select('entity_type')->distinct()->whereNotNull('entity_type')->orderBy('entity_type')->pluck('entity_type');

        return view('admin.audit-logs.index', compact('logs', 'admins', 'actions', 'entityTypes'));
    }

    public function show(AuditLog $auditLog)
    {
        $auditLog->load('admin');
        return view('admin.audit-logs.show', compact('auditLog'));
    }
}
