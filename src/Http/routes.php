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
        'middleware' => 'can:seat-industry.view_orders',
    ]);

    Route::get('/orders', [
        'as' => 'seat-industry.orders',
        'uses' => 'IndustryOrderController@orders',
        'middleware' => 'can:seat-industry.view_orders',
    ]);

    Route::get('/deliveries', [
        'as' => 'seat-industry.deliveries',
        'uses' => 'IndustryDeliveryController@deliveries',
        'middleware' => 'can:seat-industry.create_deliveries',
    ]);

    Route::get('/settings', [
        'as' => 'seat-industry.settings',
        'uses' => 'IndustrySettingsController@settings',
        'middleware' => 'can:seat-industry.settings',
    ]);

    Route::post('/settings/save', [
        'as' => 'seat-industry.saveSettings',
        'uses' => 'IndustrySettingsController@saveSettings',
        'middleware' => 'can:seat-industry.settings',
    ]);

    Route::get('/order/{id}/details', [
        'as' => 'seat-industry.orderDetails',
        'uses' => 'IndustryOrderController@orderDetails',
        'middleware' => 'can:seat-industry.view_orders',
    ]);

    Route::post('/order/{id}/reserveCorp', [
        'as' => 'seat-industry.toggleReserveCorp',
        'uses' => 'IndustryOrderController@toggleReserveCorp',
        'middleware' => 'can:seat-industry.corp_delivery',
    ]);

    Route::post('/order/{id}/confirmOrder', [
        'as' => 'seat-industry.confirmOrder',
        'uses' => 'IndustryOrderController@confirmOrder',
        'middleware' => 'can:seat-industry.view_orders',
    ]);

    Route::get('/delivery/{id}/details', [
        'as' => 'seat-industry.deliveryDetails',
        'uses' => 'IndustryDeliveryController@deliveryDetails',
        'middleware' => 'can:seat-industry.view_orders',
    ]);

    Route::get('/order/{id}/deliveries/prepare', [
        'as' => 'seat-industry.prepareDelivery',
        'uses' => 'IndustryDeliveryController@prepareDelivery',
        'middleware' => 'can:seat-industry.create_deliveries',
    ]);

    Route::post('/order/{id}/deliveries/add', [
        'as' => 'seat-industry.addDelivery',
        'uses' => 'IndustryDeliveryController@addDelivery',
        'middleware' => 'can:seat-industry.create_deliveries',
    ]);

    Route::post('/order/delete', [
        'as' => 'seat-industry.deleteOrder',
        'uses' => 'IndustryOrderController@deleteOrder',
        'middleware' => 'can:seat-industry.create_orders',
    ]);

    Route::post('/deliveries/{deliveryId}/state', [
        'as' => 'seat-industry.setDeliveryState',
        'uses' => 'IndustryDeliveryController@setDeliveryState',
        'middleware' => 'can:seat-industry.create_deliveries',
    ]);

    Route::post('/deliveries/{deliveryId}/state/{itemId}', [
        'as' => 'seat-industry.setDeliveryItemState',
        'uses' => 'IndustryDeliveryController@setDeliveryItemState',
        'middleware' => 'can:seat-industry.create_deliveries',
    ]);

    Route::post('/delivery/{deliveryId}/delete', [
        'as' => 'seat-industry.deleteDelivery',
        'uses' => 'IndustryDeliveryController@deleteDelivery',
        'middleware' => 'can:seat-industry.create_deliveries',
    ]);

    Route::post('/delivery/{deliveryId}/delete/{itemId}', [
        'as' => 'seat-industry.deleteDeliveryItem',
        'uses' => 'IndustryDeliveryController@deleteDeliveryItem',
        'middleware' => 'can:seat-industry.create_deliveries',
    ]);

    Route::get('/orders/create', [
        'as' => 'seat-industry.createOrder',
        'uses' => 'IndustryOrderController@createOrder',
        'middleware' => 'can:seat-industry.create_orders',
    ]);

    Route::post('/orders/{orderId}/update', [
        'as' => 'seat-industry.updateOrderPrice',
        'uses' => 'IndustryOrderController@updateOrderPrice',
        'middleware' => 'can:seat-industry.create_orders',
    ]);

    Route::post('/orders/{orderId}/extend', [
        'as' => 'seat-industry.extendOrderTime',
        'uses' => 'IndustryOrderController@extendOrderTime',
        'middleware' => 'can:seat-industry.create_orders',
    ]);

    Route::post('/orders/submit', [
        'as' => 'seat-industry.submitOrder',
        'uses' => 'IndustryOrderController@submitOrder',
        'middleware' => 'can:seat-industry.create_orders',
    ]);

    Route::post('/user/orders/completed/delete', [
        'as' => 'seat-industry.deleteCompletedOrders',
        'uses' => 'IndustryOrderController@deleteCompletedOrders',
        'middleware' => 'can:seat-industry.create_orders',
    ]);

    Route::get('/priceprovider/buildtime')
        ->name('seat-industry.priceprovider.buildtime.configuration')
        ->uses('IndustryController@buildTimePriceProviderConfiguration')
        ->middleware('can:pricescore.settings');

    Route::post('/priceprovider/buildtime')
        ->name('seat-industry.priceprovider.buildtime.configuration.post')
        ->uses('IndustryController@buildTimePriceProviderConfigurationPost')
        ->middleware('can:pricescore.settings');
});
