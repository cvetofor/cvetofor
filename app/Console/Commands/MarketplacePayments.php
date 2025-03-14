<?php

namespace App\Console\Commands;

use App\Jobs\MarketplacePaymentJob;
use App\Models\Market;
use Illuminate\Console\Command;

/**
 * Создание выплат для всех магазинов
 */
class MarketplacePayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'marketplace:payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создание выплат для всех магазинов';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::channel('marketplace')->info('Выплаты магазину от'. now()->format('d.m.Y h:i'));

        $markets = Market::all();

        foreach($markets as $market)
        {
            MarketplacePaymentJob::dispatch($market);
        }


        return Command::SUCCESS;
    }
}
