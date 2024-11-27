<?php

namespace Seat\HermesDj\Industry;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;
use Seat\Eveapi\Models\Industry\CharacterIndustryJob;
use Seat\Eveapi\Models\Industry\CorporationIndustryJob;
use Seat\HermesDj\Industry\Commands\SyncCorpAssetNames;
use Seat\HermesDj\Industry\Commands\SyncUserAssetNames;
use Seat\HermesDj\Industry\Http\Composers\DeliveryMenu;
use Seat\HermesDj\Industry\Http\Composers\OrderMenu;
use Seat\HermesDj\Industry\Http\Composers\OrdersMenu;
use Seat\HermesDj\Industry\Jobs\SendExpiredOrderNotifications;
use Seat\HermesDj\Industry\Models\Deliveries\Delivery;
use Seat\HermesDj\Industry\Models\Industry\ActivityTypeEnum;
use Seat\HermesDj\Industry\Models\Industry\IndustryActivityProducts;
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

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations/');

        Delivery::observe(DeliveryObserver::class);
        Order::observe(OrderObserver::class);
        User::observe(UserObserver::class);

        $this->addCommands();
        $this->addMigrations();
        $this->addViews();
        $this->addViewComposers();
        $this->addTranslations();
        $this->addCommands();
        $this->addRoutes();
        $this->addRelations();
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/seat-industry.sidebar.php', 'package.sidebar');
        $this->mergeConfigFrom(__DIR__ . '/Config/notifications.alerts.php', 'notifications.alerts');
        $this->mergeConfigFrom(__DIR__ . '/Config/inventory.sources.php', 'inventory.sources');
        $this->mergeConfigFrom(__DIR__ . '/Config/seat-industry.sde.tables.php', 'seat.sde.tables');

        // Menus
        $this->mergeConfigFrom(__DIR__ . '/Config/package.orders.menu.php', 'package.seat-industry.orders.menu');
        $this->mergeConfigFrom(__DIR__ . '/Config/package.order.menu.php', 'package.seat-industry.order.menu');
        $this->mergeConfigFrom(__DIR__ . '/Config/package.delivery.menu.php', 'package.seat-industry.delivery.menu');

        $this->registerPermissions(__DIR__ . '/Config/seat-industry.permissions.php', 'seat-industry');

        Gate::define('seat-industry.same-user', UserPolicy::class . '@checkUser');
    }

    private function addRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
    }

    private function addViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views/', 'seat-industry');
    }

    private function addViewComposers(): void
    {
        $this->app['view']->composer([
            'seat-industry::orders.includes.menu',
        ], OrderMenu::class);

        $this->app['view']->composer([
            'seat-industry::deliveries.includes.menu',
        ], DeliveryMenu::class);

        $this->app['view']->composer([
            'seat-industry::orders.includes.mainMenu',
        ], OrdersMenu::class);
    }

    private function addTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang/', 'seat-industry');
    }

    private function addMigrations(): void
    {
    }

    private function addCommands(): void
    {
        $this->commands([
            SyncCorpAssetNames::class,
            SyncUserAssetNames::class,
        ]);

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
    }

    private function addRelations(): void
    {
        CorporationIndustryJob::resolveRelationUsing('industryActivityProductManufacturing', function (CorporationIndustryJob $model) {
            return $model->hasOne(IndustryActivityProducts::class, 'typeID', 'blueprint_type_id')
                ->where('activityID', ActivityTypeEnum::MANUFACTURING);
        });

        CharacterIndustryJob::resolveRelationUsing('industryActivityProductManufacturing', function (CharacterIndustryJob $model) {
            return $model->hasOne(IndustryActivityProducts::class, 'typeID', 'blueprint_type_id')
                ->where('activityID', ActivityTypeEnum::MANUFACTURING);
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
