<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The app switched from UTC writes on a server-local (+05:00) MySQL
     * session to matching Karachi app/database time at this cutoff.
     * Legacy TIMESTAMP wall times before it are five hours behind local time.
     */
    private const LEGACY_CUTOFF = '2026-09-28 01:00:00';

    // my_list.added_at is omitted intentionally; MyList disables Eloquent
    // timestamps and MySQL itself generated that field in the server timezone.
    private const COLUMNS = [
        'admin_activity_logs' => ['created_at'],
        'analytics_events' => ['created_at'],
        'articles' => ['published_at', 'created_at', 'updated_at', 'deleted_at'],
        'bookmarks' => ['created_at', 'updated_at'],
        'categories' => ['created_at', 'updated_at'],
        'characters' => ['created_at', 'updated_at'],
        'chat_messages' => ['created_at'],
        'chat_sessions' => ['created_at', 'updated_at'],
        'contents' => ['created_at', 'updated_at', 'deleted_at'],
        'content_notes' => ['created_at', 'updated_at'],
        'daily_stats' => ['created_at', 'updated_at'],
        'events' => ['created_at', 'updated_at', 'deleted_at'],
        'event_rsvps' => ['created_at'],
        'failed_jobs' => ['failed_at'],
        'faqs' => ['created_at', 'updated_at'],
        'feedback' => ['created_at', 'updated_at'],
        'merchandise' => ['created_at', 'updated_at', 'deleted_at'],
        'merchandise_images' => ['created_at', 'updated_at'],
        'merchandise_tags' => ['created_at', 'updated_at'],
        'password_reset_tokens' => ['created_at'],
        'profiles' => ['created_at', 'updated_at'],
        'ratings' => ['created_at', 'updated_at'],
        'resources' => ['created_at', 'updated_at'],
        'site_settings' => ['created_at', 'updated_at'],
        'tags' => ['created_at', 'updated_at'],
        'timeline_events' => ['created_at', 'updated_at'],
        'users' => ['email_verified_at', 'password_changed_at', 'banned_at', 'deleted_at', 'created_at', 'updated_at'],
        'watch_progress' => ['updated_at'],
    ];

    public function up(): void
    {
        if (! in_array(DB::connection()->getDriverName(), ['mysql', 'mariadb'], true)) {
            return;
        }

        foreach (self::COLUMNS as $table => $columns) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            foreach ($columns as $column) {
                if (! Schema::hasColumn($table, $column)) {
                    continue;
                }

                DB::table($table)
                    ->whereNotNull($column)
                    ->where($column, '<', self::LEGACY_CUTOFF)
                    ->update([$column => DB::raw("DATE_ADD(`{$column}`, INTERVAL 5 HOUR)")]);
            }
        }
    }

    public function down(): void
    {
        // This is a one-time correction to stored instants. Reversing it later
        // could shift valid post-cutover data, so the normalized values remain.
    }
};
