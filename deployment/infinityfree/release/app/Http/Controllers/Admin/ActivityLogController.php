<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $logs = AdminActivityLog::with('admin')
            ->when($request->admin_id, fn($q, $v) => $q->where('admin_id', $v))
            ->when($request->action,   fn($q, $v) => $q->where('action', 'like', "%{$v}%"))
            ->when($request->from,     fn($q, $v) => $q->whereDate('created_at', '>=', $v))
            ->when($request->to,       fn($q, $v) => $q->whereDate('created_at', '<=', $v))
            ->latest()
            ->paginate(50)
            ->withQueryString();

        // Admins list for the filter dropdown
        $admins = User::where(fn ($query) => $query->where('is_admin', true)->orWhere('role', 'admin'))
            ->orderBy('name')->get(['id', 'name']);

        return view('admin.activity-log.index', compact('logs', 'admins'));
    }
}
