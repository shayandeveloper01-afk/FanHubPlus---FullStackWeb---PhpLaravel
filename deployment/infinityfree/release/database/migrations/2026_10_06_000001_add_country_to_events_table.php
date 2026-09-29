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
            // Hyderabad is intentionally omitted because both Pakistan and India have a major city by that name.
            'Pakistan' => ['Karachi','Lahore','Islamabad','Rawalpindi','Faisalabad','Multan','Peshawar','Quetta','Sialkot','Gujranwala','Abbottabad','Bahawalpur','Sukkur'],
            'India' => ['Mumbai','Delhi','Bengaluru','Chennai'],
            'United Arab Emirates' => ['Dubai','Abu Dhabi','Sharjah','Ajman'],
            'Saudi Arabia' => ['Riyadh','Jeddah','Mecca','Medina'],
            'Japan' => ['Tokyo','Osaka','Kyoto','Yokohama','Nagoya'],
            'South Korea' => ['Seoul','Busan','Incheon','Daegu'],
            'China' => ['Beijing','Shanghai','Shenzhen','Guangzhou'],
            'United States' => ['Indio','Las Vegas','Los Angeles','New York','Chicago'],
            'United Kingdom' => ['London','Manchester','Birmingham','Edinburgh','Somerset'],
            'Canada' => ['Toronto','Vancouver','Montreal','Ottawa'],
            'Australia' => ['Sydney','Melbourne','Brisbane','Perth'],
            'Germany' => ['Berlin','Munich','Hamburg','Cologne'],
            'France' => ['Paris','Lyon','Marseille','Nice'],
            'Turkey' => ['Istanbul','Ankara','Izmir','Antalya'],
            'Malaysia' => ['Kuala Lumpur','George Town','Johor Bahru','Kota Kinabalu'],
            'Singapore' => ['Singapore'],
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
