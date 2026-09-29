<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Models\AdminActivityLog;

trait LogsAdminActivity
{
    /**
     * Write one audit log entry.
     *
     * @param  string       $action      e.g. 'user.ban', 'content.delete'
     * @param  string|null  $targetType  Model class short name, e.g. 'User'
     * @param  int|null     $targetId
     * @param  string|null  $notes       Human-readable detail shown in the log viewer
     */
    protected function auditLog(
        string  $action,
        ?string $targetType = null,
        ?int    $targetId   = null,
        ?string $notes      = null
    ): void {
        try {
            AdminActivityLog::create([
                'admin_id'    => auth()->id(),
                'action'      => $action,
                'target_type' => $targetType,
                'target_id'   => $targetId,
                'notes'       => $notes,
            ]);
        } catch (\Throwable) {
            // Audit logging is best-effort — never break the main request
        }
    }
}
