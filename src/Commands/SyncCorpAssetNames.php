<?php

namespace Seat\HermesDj\Industry\Commands;

use Illuminate\Console\Command;
use Seat\Eveapi\Models\RefreshToken;
use Seat\HermesDj\Industry\Bus\CorpAssetBus;
use Seat\HermesDj\Industry\Models\Orders\Order;

class SyncCorpAssetNames extends Command
{
    protected $signature = 'seat-industry:assets:corp:names';

    protected $description = 'Update corp assets & assets names for station containers';

    public function handle()
    {
        $orders = Order::where('completed', false)->with('corporation')->get();
        $corporations = $orders->pluck('corporation');

        if ($corporations->isEmpty()) {
            logger()->debug('No corporations found');

            return $this::INVALID;
        } else {
            $corporations->each(function ($corp) {
                if ($corp) {
                    $token = RefreshToken::find($corp->ceo_id);

                    if ($token) {
                        $this->info(sprintf('Processing corporation assets %s', $corp->name));
                        (new CorpAssetBus($corp->corporation_id, $token))->fire();
                    }
                }
            });

            return $this::SUCCESS;
        }
    }
}