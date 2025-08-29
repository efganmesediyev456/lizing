<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CashboxService;
use Carbon\Carbon;

class CloseDailyCashbox extends Command
{
    protected $signature = 'cashbox:close-daily {date?}';
    protected $description = 'Close daily cashbox report for a date (default: today)';

    public function handle(CashboxService $service)
    {
        $date = $this->argument('date')
            ? Carbon::parse($this->argument('date'), 'Asia/Baku')
            : Carbon::today('Asia/Baku');

        $report = $service->closeDay($date, null);
        $this->info("Closed cashbox for {$report->report_date->toDateString()}, net={$report->net_total}");
        return self::SUCCESS;
    }
}
