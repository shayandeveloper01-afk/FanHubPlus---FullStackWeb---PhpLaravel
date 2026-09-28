<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('events', 'country')) {
            Schema::table('events', function (Blueprint $table): void {
                $table->string('country', 100)->nullable()->after('city')->index();
            });
        }

        // Backfill only cities whose country is unambiguous in the existing catalog.
        $knownCities = [
            'Pakistan' => ['Karachi','Lahore','Islamabad','Rawalpindi','Faisalabad','Multan','Peshawar','Quetta','Hyderabad','Sialkot','Gujranwala','Abbottabad','Bahawalpur','Sukkur'],
            'Japan' => ['Tokyo'], 'United States' => ['Indio','Las Vegas','Los Angeles'],
            'United Kingdom' => ['London'], 'Germany' => ['Cologne'],
        ];
        foreach ($knownCities as $country => $cities) {
            DB::table('events')->whereNull('country')->whereIn('city', $cities)->update(['country' => $country]);
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('events', 'country')) {
            Schema::table('events', fn (Blueprint $table) => $table->dropColumn('country'));
        }
    }
};
