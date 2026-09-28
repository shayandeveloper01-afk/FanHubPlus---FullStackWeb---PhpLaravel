<?php

namespace App\Console\Commands;

use App\Models\AnalyticsEvent;
use App\Models\DailyStat;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AggregateDailyStats extends Command
{
    protected $signature = 'analytics:aggregate-daily {date?}';
    protected $description = 'Pre-aggregate analytics event counts by day and event type';

    public function handle(): int
    {
        $date = $this->argument('date') ?: now()->subDay()->toDateString();
        $counts = AnalyticsEvent::query()->whereDate('created_at', $date)
            ->select('event_type', DB::raw('COUNT(*) AS total'))
            ->groupBy('event_type')->pluck('total', 'event_type');

        foreach ($counts as $metric => $value) {
            DailyStat::updateOrCreate(['date' => $date, 'metric' => $metric], ['value' => $value]);
        }
        $this->info("Aggregated {$counts->count()} metrics for {$date}.");
        return self::SUCCESS;
    }
}
