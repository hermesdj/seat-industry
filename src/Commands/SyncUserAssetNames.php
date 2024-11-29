<?php

namespace Seat\HermesDj\Industry\Commands;

use Illuminate\Console\Command;
use Seat\HermesDj\Industry\Bus\UserAssetBus;
use Seat\HermesDj\Industry\Models\Deliveries\Delivery;

class SyncUserAssetNames extends Command
{
    protected $signature = 'seat-industry:assets:user:names';

    protected $description = 'Update all of a user character assets & asset names for station containers';

    public function handle()
    {
        $deliveries = Delivery::where('completed', false)->with('user')->get();
        $users = $deliveries->pluck('user')->unique();

        foreach ($users as $user) {
            (new UserAssetBus($user->id))->fire();

            $this->info(sprintf('Processing user assets update %s', $user->main_character->name));
        }

        return $this::SUCCESS;
    }
}
