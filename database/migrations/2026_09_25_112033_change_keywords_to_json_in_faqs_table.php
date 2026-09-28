<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // This migration is intentionally ordered before the current create
        // migration in the repository, so a fresh install may not have the
        // table yet. The create migration now defines the JSON column directly.
        if (!Schema::hasTable('faqs') || !Schema::hasColumn('faqs', 'keywords')) {
            return;
        }

        // Avoid converting an already-JSON column if this migration is retried
        // after a partially completed deployment. MySQL exposes JSON columns
        // as longtext through Laravel's schema metadata, so also inspect the
        // stored value when the table contains rows.
        $columnType = Schema::getColumnType('faqs', 'keywords');
        $hasJsonValue = DB::table('faqs')->get()->contains(
            fn ($faq) => is_array(json_decode((string) ($faq->keywords ?? ''), true))
        );
        if (in_array($columnType, ['json', 'array'], true) || $hasJsonValue) {
            return;
        }

        if (!Schema::hasColumn('faqs', 'keywords_json')) {
            Schema::table('faqs', function (Blueprint $table) {
                $table->json('keywords_json')->nullable()->after('keywords');
            });
        }

        // Convert existing comma-separated strings to JSON arrays.
        DB::table('faqs')->get()->each(function ($faq) {
            $arr = array_values(array_filter(
                array_map('trim', explode(',', (string) ($faq->keywords ?? '')))
            ));
            DB::table('faqs')->where('id', $faq->id)->update([
                'keywords_json' => json_encode($arr),
            ]);
        });

        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn('keywords');
        });

        Schema::table('faqs', function (Blueprint $table) {
            $table->renameColumn('keywords_json', 'keywords');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('faqs') || !Schema::hasColumn('faqs', 'keywords')) {
            return;
        }

        // Convert the JSON representation back to the legacy comma-separated
        // representation used by older application versions.
        if (!Schema::hasColumn('faqs', 'keywords_tmp')) {
            Schema::table('faqs', function (Blueprint $table) {
                $table->string('keywords_tmp')->nullable()->after('keywords');
            });
        }

        DB::table('faqs')->get()->each(function ($faq) {
            $arr = json_decode((string) ($faq->keywords ?? '[]'), true);
            $arr = is_array($arr) ? $arr : [];
            DB::table('faqs')->where('id', $faq->id)->update([
                'keywords_tmp' => implode(',', $arr),
            ]);
        });

        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn('keywords');
        });

        Schema::table('faqs', function (Blueprint $table) {
            $table->renameColumn('keywords_tmp', 'keywords');
        });
    }
};
