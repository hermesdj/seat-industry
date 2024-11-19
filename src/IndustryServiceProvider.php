<?php

namespace HermesDj\Seat\Industry;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;
use HermesDj\Seat\Industry\Jobs\RemoveExpiredDeliveries;
use HermesDj\Seat\Industry\Jobs\SendExpiredOrderNotifications;
use HermesDj\Seat\Industry\Jobs\UpdateRepeatingOrders;
use HermesDj\Seat\Industry\Models\Delivery;
use HermesDj\Seat\Industry\Models\Order;
use HermesDj\Seat\Industry\Observers\DeliveryObserver;
use HermesDj\Seat\Industry\Observers\OrderObserver;
use HermesDj\Seat\Industry\Observers\UserObserver;
use HermesDj\Seat\Industry\Policies\UserPolicy;
use Seat\Services\AbstractSeatPlugin;
use Seat\Web\Models\User;

class IndustryServiceProvider extends AbstractSeatPlugin
{
    public function boot(): void
    {
        IndustrySettings::init();

        if (!$this->app->routesAreCached()) {
            include __DIR__ . '/Http/routes.php';
        }

        $this->loadTranslationsFrom(__DIR__ . '/resources/lang/', 'seat-industry');
        $this->loadViewsFrom(__DIR__ . '/resources/views/', 'seat-industry');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations/');

        Gate::define('Industry.same-user', UserPolicy::class . '@checkUser');

        Delivery::observe(DeliveryObserver::class);
        Order::observe(OrderObserver::class);
        User::observe(UserObserver::class);

        $this->mergeConfigFrom(
            __DIR__ . '/Config/notifications.alerts.php', 'notifications.alerts'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/Config/inventory.sources.php', 'inventory.sources'
        );
        $this->mergeConfigFrom(__DIR__ . '/Config/priceproviders.backends.php', 'priceproviders.backends');

        $this->mergeConfigFrom(__DIR__ . '/Config/Industry.sde.tables.php', 'seat.sde.tables');

        Artisan::command('seat-industry:notifications {--sync}', function () {
            if ($this->option("sync")) {
                $this->info("processing...");
                SendExpiredOrderNotifications::dispatchSync();
                $this->info("Synchronously sent notification!");
            } else {
                SendExpiredOrderNotifications::dispatch()->onQueue('notifications');
                $this->info("Scheduled notifications!");
            }
        });

        Artisan::command('seat-industry:orders:repeating {--sync}', function () {
            if ($this->option("sync")) {
                UpdateRepeatingOrders::dispatchSync();
            } else {
                UpdateRepeatingOrders::dispatch();
            }
        });

        Artisan::command('seat-industry:deliveries:expired {--sync}', function () {
            if ($this->option("sync")) {
                RemoveExpiredDeliveries::dispatchSync();
            } else {
                RemoveExpiredDeliveries::dispatch();
            }
        });
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/industry.sidebar.php', 'package.sidebar');
        $this->registerPermissions(__DIR__ . '/Config/Industry.permissions.php', 'Industry');
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