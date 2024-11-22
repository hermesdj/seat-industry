<?php

namespace Seat\HermesDj\Industry;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;
use Seat\HermesDj\Industry\Jobs\RemoveExpiredDeliveries;
use Seat\HermesDj\Industry\Jobs\SendExpiredOrderNotifications;
use Seat\HermesDj\Industry\Jobs\UpdateRepeatingOrders;
use Seat\HermesDj\Industry\Models\Deliveries\Delivery;
use Seat\HermesDj\Industry\Models\Orders\Order;
use Seat\HermesDj\Industry\Observers\DeliveryObserver;
use Seat\HermesDj\Industry\Observers\OrderObserver;
use Seat\HermesDj\Industry\Observers\UserObserver;
use Seat\HermesDj\Industry\Policies\UserPolicy;
use Seat\Services\AbstractSeatPlugin;
use Seat\Web\Models\User;

class IndustryServiceProvider extends AbstractSeatPlugin
{
    public function boot(): void
    {
        IndustrySettings::init();

        $this->loadMigrationsFrom(__DIR__.'/database/migrations/');

        Delivery::observe(DeliveryObserver::class);
        Order::observe(OrderObserver::class);
        User::observe(UserObserver::class);

        $this->addCommands();
        $this->addViews();
        $this->addTranslations();
        $this->addCommands();
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/Config/seat-industry.sidebar.php', 'package.sidebar');
        $this->mergeConfigFrom(__DIR__.'/Config/notifications.alerts.php', 'notifications.alerts');
        $this->mergeConfigFrom(__DIR__.'/Config/inventory.sources.php', 'inventory.sources');
        $this->mergeConfigFrom(__DIR__.'/Config/priceproviders.backends.php', 'priceproviders.backends');
        $this->mergeConfigFrom(__DIR__.'/Config/seat-industry.sde.tables.php', 'seat.sde.tables');

        $this->registerPermissions(__DIR__.'/Config/seat-industry.permissions.php', 'seat-industry');

        Gate::define('seat-industry.same-user', UserPolicy::class.'@checkUser');
    }

    private function addRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
    }

    private function addViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/resources/views/', 'seat-industry');
    }

    private function addTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/resources/lang/', 'seat-industry');
    }

    private function addMigrations(): void {}

    private function addCommands(): void
    {
        Artisan::command('seat-industry:notifications {--sync}', function () {
            if ($this->option('sync')) {
                $this->info('processing...');
                SendExpiredOrderNotifications::dispatchSync();
                $this->info('Synchronously sent notification!');
            } else {
                SendExpiredOrderNotifications::dispatch()->onQueue('notifications');
                $this->info('Scheduled notifications!');
            }
        });

        Artisan::command('seat-industry:orders:repeating {--sync}', function () {
            if ($this->option('sync')) {
                UpdateRepeatingOrders::dispatchSync();
            } else {
                UpdateRepeatingOrders::dispatch();
            }
        });

        Artisan::command('seat-industry:deliveries:expired {--sync}', function () {
            if ($this->option('sync')) {
                RemoveExpiredDeliveries::dispatchSync();
            } else {
                RemoveExpiredDeliveries::dispatch();
            }
        });
    }

    public function getName(): string
    {
        return 'SeAT Industry Planner';
    }

    public function getPackageRepositoryUrl(): string
    {
        return 'https://github.com/hermesdj/seat-industry';
    }

    public function getPackagistPackageName(): string
    {
        return 'seat-industry';
    }

    public function getPackagistVendorName(): string
    {
        return 'hermesdj';
    }
}
