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
        self::$LAST_NOTIFICATION_BATCH = Setting::create("Industry", "notifications.batch.last", true);
        self::$DEFAULT_ORDER_LOCATION = Setting::create("Industry", "order.location.default", true);
        self::$DEFAULT_PRICE_PROVIDER = Setting::create("Industry", "order.price.provider.default", true);
        self::$REMOVE_EXPIRED_DELIVERIES = Setting::create("Industry", "deliveries.expired.remove", true);
        self::$DEFAULT_PRIORITY = Setting::create("Industry", "order.priority.default", true);

        //with manual key because it is migrated from the old settings system
        self::$MINIMUM_PROFIT_PERCENTAGE = Setting::createFromKey("recursivetree.Industry.minimumProfitPercentage", true);
        self::$ORDER_CREATION_PING_ROLES = Setting::createFromKey("recursivetree.Industry.orderCreationPingRoles", true);
        self::$ALLOW_PRICES_BELOW_AUTOMATIC = Setting::createFromKey("recursivetree.Industry.allowPricesBelowAutomatic", true);
        self::$NOTIFICATION_COMMAND_SCHEDULE_ID = Setting::createFromKey("recursivetree.Industry.notifications_schedule_id", true);

        self::$ALLOWED_PRICE_PROVIDERS = Setting::createFromKey("recursivetree.Industry.allowedPriceProviders", true);

        // when migrating fresh, this error might trigger
        try {
            $price_provider = self::$DEFAULT_PRICE_PROVIDER->get();
            if (!is_numeric($price_provider)) {
                self::$DEFAULT_PRICE_PROVIDER->set(null);
            }
        } catch (QueryException $_) {
        }
    }
}