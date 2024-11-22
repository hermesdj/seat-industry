<?php

namespace Seat\HermesDj\Industry;

use Illuminate\Database\QueryException;
use RecursiveTree\Seat\TreeLib\Helpers\Setting;

class IndustrySettings
{
    public static $LAST_NOTIFICATION_BATCH;

    public static $LAST_EXPIRING_NOTIFICATION_BATCH;

    public static $MINIMUM_PROFIT_PERCENTAGE;

    public static $ORDER_CREATION_PING_ROLES;

    public static $ALLOW_PRICES_BELOW_AUTOMATIC;

    public static $DEFAULT_ORDER_LOCATION;

    public static $DEFAULT_PRICE_PROVIDER;

    public static $REMOVE_EXPIRED_DELIVERIES;

    public static $DEFAULT_PRIORITY;

    //used in an earlier iteration of the notification system, still used in migrations
    public static $NOTIFICATION_COMMAND_SCHEDULE_ID;

    public static $ALLOWED_PRICE_PROVIDERS;

    public static function init(): void
    {
        self::$LAST_NOTIFICATION_BATCH = Setting::create("seat-industry", "notifications.batch.last", true);
        self::$DEFAULT_ORDER_LOCATION = Setting::create("seat-industry", "order.location.default", true);
        self::$DEFAULT_PRICE_PROVIDER = Setting::create("seat-industry", "order.price.provider.default", true);
        self::$REMOVE_EXPIRED_DELIVERIES = Setting::create("seat-industry", "deliveries.expired.remove", true);
        self::$DEFAULT_PRIORITY = Setting::create("seat-industry", "order.priority.default", true);

        //with manual key because it is migrated from the old settings system
        self::$MINIMUM_PROFIT_PERCENTAGE = Setting::createFromKey("hermesdj.seat-industry.minimumProfitPercentage", true);
        self::$ORDER_CREATION_PING_ROLES = Setting::createFromKey("hermesdj.seat-industry.orderCreationPingRoles", true);
        self::$ALLOW_PRICES_BELOW_AUTOMATIC = Setting::createFromKey("hermesdj.seat-industry.allowPricesBelowAutomatic", true);
        self::$NOTIFICATION_COMMAND_SCHEDULE_ID = Setting::createFromKey("hermesdj.seat-industry.notifications_schedule_id", true);

        self::$ALLOWED_PRICE_PROVIDERS = Setting::createFromKey("hermesdj.seat-industry.allowedPriceProviders", true);

        // when migrating fresh, this error might trigger
        try {
            $price_provider = self::$DEFAULT_PRICE_PROVIDER->get();
            if (! is_numeric($price_provider)) {
                self::$DEFAULT_PRICE_PROVIDER->set(null);
            }
        } catch (QueryException $_) {
        }
    }
}
