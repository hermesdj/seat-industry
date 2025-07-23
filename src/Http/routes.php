<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'Seat\HermesDj\Industry\Http\Controllers',
    'middleware' => ['web', 'auth', 'locale'],
    'prefix' => 'seat-industry',
], function () {
    Route::get('/about', [
        'as' => 'seat-industry.about',
        'uses' => 'IndustryController@about',
        'middleware' => 'can:seat-industry.create_orders',
    ]);

    Route::group([
        'prefix' => 'orders',
    ], function (): void {
        Route::get('/', [
            'as' => 'seat-industry.orders',
            'uses' => 'IndustryOrderController@orders',
            'middleware' => 'can:seat-industry.view_orders',
        ]);

        Route::get('/corporation', [
            'as' => 'seat-industry.corporationOrders',
            'uses' => 'IndustryOrderController@corporationOrders',
            'middleware' => 'can:seat-industry.corp_delivery',
        ]);

        Route::get('/myOrders', [
            'as' => 'seat-industry.myOrders',
            'uses' => 'IndustryOrderController@myOrders',
            'middleware' => 'can:seat-industry.create_orders',
        ]);

        Route::get('/expiredOrders', [
            'as' => 'seat-industry.expiredOrders',
            'uses' => 'IndustryOrderController@expiredOrders',
            'middleware' => 'can:seat-industry.admin',
        ]);

        Route::get('/allConfirmedOrders', [
            'as' => 'seat-industry.allConfirmedOrders',
            'uses' => 'IndustryOrderController@allConfirmedOrders',
            'middleware' => 'can:seat-industry.manager',
        ]);

        Route::get('/create', [
            'as' => 'seat-industry.createOrder',
            'uses' => 'IndustryOrderController@createOrder',
            'middleware' => 'can:seat-industry.create_orders',
        ]);

        Route::post('/{order}/update', [
            'as' => 'seat-industry.updateOrderPrice',
            'uses' => 'IndustryOrderController@updateOrderPrice',
            'middleware' => 'can:seat-industry.create_orders',
        ]);

        Route::post('/{order}/extend', [
            'as' => 'seat-industry.extendOrderTime',
            'uses' => 'IndustryOrderController@extendOrderTime',
            'middleware' => 'can:seat-industry.create_orders',
        ]);

        Route::post('/{order}/edit', [
            'as' => 'seat-industry.editDetails',
            'uses' => 'IndustryOrderController@updateOrderDetails',
            'middleware' => 'can:seat-industry.create_orders',
        ]);

        Route::post('/submit', [
            'as' => 'seat-industry.submitOrder',
            'uses' => 'IndustryOrderController@submitOrder',
            'middleware' => 'can:seat-industry.create_orders',
        ]);

        Route::post('/{order}/deliveries/prepare', [
            'as' => 'seat-industry.prepareDelivery',
            'uses' => 'IndustryDeliveryController@prepareDelivery',
            'middleware' => 'can:seat-industry.create_deliveries',
        ]);

        Route::post('/{order}/deliveries/add', [
            'as' => 'seat-industry.addDelivery',
            'uses' => 'IndustryDeliveryController@addDelivery',
            'middleware' => 'can:seat-industry.create_deliveries',
        ]);

        Route::post('/{order}/delete', [
            'as' => 'seat-industry.deleteOrder',
            'uses' => 'IndustryOrderController@deleteOrder',
            'middleware' => 'can:seat-industry.create_orders',
        ]);

        Route::post('/{order}/complete', [
            'as' => 'seat-industry.completeOrder',
            'uses' => 'IndustryOrderController@completeOrder',
            'middleware' => 'can:seat-industry.create_orders',
        ]);

        Route::get('/{order}/details', [
            'as' => 'seat-industry.orderDetails',
            'uses' => 'IndustryOrderController@orderDetails',
            'middleware' => 'can:seat-industry.create_orders',
        ]);

        Route::get('/{order}/deliveryDetails', [
            'as' => 'seat-industry.orderDeliveryDetails',
            'uses' => 'IndustryOrderController@orderDeliveryDetails',
            'middleware' => 'can:seat-industry.create_orders',
        ]);

        Route::get('/{order}/ravworks', [
            'as' => 'seat-industry.ravworksDetails',
            'uses' => 'IndustryOrderController@ravworksDetails',
            'middleware' => 'can:seat-industry.create_deliveries',
        ]);

        Route::get('/{order}/buildPlan', [
            'as' => 'seat-industry.buildPlan',
            'uses' => 'IndustryOrderController@buildPlan',
            'middleware' => 'can:seat-industry.create_deliveries',
        ]);

        Route::post('/{order}/reserveCorp', [
            'as' => 'seat-industry.toggleReserveCorp',
            'uses' => 'IndustryOrderController@toggleReserveCorp',
            'middleware' => 'can:seat-industry.corp_delivery',
        ]);

        Route::post('/{order}/confirmOrder', [
            'as' => 'seat-industry.confirmOrder',
            'uses' => 'IndustryOrderController@confirmOrder',
            'middleware' => 'can:seat-industry.create_orders',
        ]);

        Route::post('/{order}/updateOrderItemState', [
            'as' => 'seat-industry.updateOrderItemState',
            'uses' => 'IndustryOrderController@updateOrderItemState',
            'middleware' => 'can:seat-industry.admin',
        ]);

        Route::post('/{order}/updateStocks', [
            'as' => 'seat-industry.updateStocks',
            'uses' => 'IndustryOrderController@updateStocks',
            'middleware' => 'can:seat-industry.update_stocks',
        ]);

        Route::post('/my/completed/delete', [
            'as' => 'seat-industry.deleteCompletedOrders',
            'uses' => 'IndustryOrderController@deleteCompletedOrders',
            'middleware' => 'can:seat-industry.create_orders',
        ]);
    });

    Route::group([
        'prefix' => 'deliveries',
    ], function (): void {
        Route::get('/allDeliveries', [
            'as' => 'seat-industry.allDeliveries',
            'uses' => 'IndustryDeliveryController@allDeliveries',
            'middleware' => 'can:seat-industry.manager',
        ]);

        Route::get('/myUnfulfilledDeliveries', [
            'as' => 'seat-industry.myUnfulfilledDeliveries',
            'uses' => 'IndustryDeliveryController@myUnfulfilledDeliveries',
            'middleware' => 'can:seat-industry.create_deliveries',
        ]);

        Route::get('/{delivery}/details', [
            'as' => 'seat-industry.deliveryDetails',
            'uses' => 'IndustryDeliveryController@deliveryDetails',
            'middleware' => 'can:seat-industry.create_deliveries',
        ]);

        Route::get('/{delivery}/ravworks', [
            'as' => 'seat-industry.deliveryRavworksDetails',
            'uses' => 'IndustryDeliveryController@deliveryRavworksDetails',
            'middleware' => 'can:seat-industry.create_deliveries',
        ]);

        Route::get('/{delivery}/buildPlan', [
            'as' => 'seat-industry.deliveryBuildPlan',
            'uses' => 'IndustryDeliveryController@deliveryBuildPlan',
            'middleware' => 'can:seat-industry.create_deliveries',
        ]);

        Route::post('/{delivery}/state', [
            'as' => 'seat-industry.setDeliveryState',
            'uses' => 'IndustryDeliveryController@setDeliveryState',
            'middleware' => 'can:seat-industry.create_deliveries',
        ]);

        Route::post('/{delivery}/state/{item}', [
            'as' => 'seat-industry.setDeliveryItemState',
            'uses' => 'IndustryDeliveryController@setDeliveryItemState',
            'middleware' => 'can:seat-industry.create_deliveries',
        ]);

        Route::post('/{delivery}/delete', [
            'as' => 'seat-industry.deleteDelivery',
            'uses' => 'IndustryDeliveryController@deleteDelivery',
            'middleware' => 'can:seat-industry.create_deliveries',
        ]);

        Route::post('/{delivery}/delete/{item}', [
            'as' => 'seat-industry.deleteDeliveryItem',
            'uses' => 'IndustryDeliveryController@deleteDeliveryItem',
            'middleware' => 'can:seat-industry.create_deliveries',
        ]);
    });

    Route::group([
        'prefix' => 'profiles',
    ], function (): void {
        Route::get('/', [
            'as' => 'seat-industry.profiles',
            'uses' => 'IndustryProfileController@profiles',
            'middleware' => 'can:seat-industry.create_orders',
        ]);

        Route::get('/{profile}', [
            'as' => 'seat-industry.profile',
            'uses' => 'IndustryProfileController@profile',
            'middleware' => 'can:seat-industry.create_orders',
        ]);

        Route::post('/', [
            'as' => 'seat-industry.createProfile',
            'uses' => 'IndustryProfileController@createProfile',
            'middleware' => 'can:seat-industry.create_orders',
        ]);

        Route::post('/{profile}', [
            'as' => 'seat-industry.updateProfile',
            'uses' => 'IndustryProfileController@updateProfile',
            'middleware' => 'can:seat-industry.create_orders',
        ]);

        Route::post('/{profile}/delete', [
            'as' => 'seat-industry.deleteProfile',
            'uses' => 'IndustryProfileController@deleteProfile',
            'middleware' => 'can:seat-industry.create_orders',
        ]);
    });

    Route::group([
        'prefix' => 'settings',
    ], function (): void {
        Route::get('/', [
            'as' => 'seat-industry.settings',
            'uses' => 'IndustrySettingsController@settings',
            'middleware' => 'can:seat-industry.settings',
        ]);

        Route::post('/save', [
            'as' => 'seat-industry.saveSettings',
            'uses' => 'IndustrySettingsController@saveSettings',
            'middleware' => 'can:seat-industry.settings',
        ]);
    });

    Route::group([
        'prefix' => 'statistics',
    ], function (): void {
        Route::get('/scoreboard', [
            'as' => 'seat-industry.scoreboard',
            'uses' => 'IndustryStatsController@scoreboard',
            'middleware' => 'can:seat-industry.view_scoreboard',
        ]);
    });
});
