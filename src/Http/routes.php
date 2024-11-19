<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => 'HermesDj\Seat\Industry\Http\Controllers',
    'middleware' => ['web', 'auth', 'locale'],
    'prefix' => 'seat-industry',
], function () {
    Route::get('/about', [
        'as' => 'seat-industry.about',
        'uses' => 'IndustryController@about',
        'middleware' => 'can:Industry.view_orders'
    ]);

    Route::get('/orders', [
        'as' => 'seat-industry.orders',
        'uses' => 'IndustryOrderController@orders',
        'middleware' => 'can:Industry.view_orders'
    ]);

    Route::get('/deliveries', [
        'as' => 'Industry.deliveries',
        'uses' => 'IndustryDeliveryController@deliveries',
        'middleware' => 'can:Industry.create_deliveries'
    ]);

    Route::get('/settings', [
        'as' => 'Industry.settings',
        'uses' => 'IndustrySettingsController@settings',
        'middleware' => 'can:Industry.settings'
    ]);

    Route::post('/settings/save', [
        'as' => 'Industry.saveSettings',
        'uses' => 'IndustrySettingsController@saveSettings',
        'middleware' => 'can:Industry.settings'
    ]);

    Route::get('/order/{id}/details', [
        'as' => 'Industry.orderDetails',
        'uses' => 'IndustryOrderController@orderDetails',
        'middleware' => 'can:Industry.view_orders'
    ]);

    Route::post('/order/{id}/reserveCorp', [
        'as' => 'Industry.toggleReserveCorp',
        'uses' => 'IndustryOrderController@toggleReserveCorp',
        'middleware' => 'can:Industry.corp_delivery'
    ]);

    Route::post('/order/{id}/confirmOrder', [
        'as' => 'Industry.confirmOrder',
        'uses' => 'IndustryOrderController@confirmOrder',
        'middleware' => 'can:Industry.view_orders'
    ]);

    Route::get('/delivery/{id}/details', [
        'as' => 'Industry.deliveryDetails',
        'uses' => 'IndustryDeliveryController@deliveryDetails',
        'middleware' => 'can:Industry.view_orders'
    ]);

    Route::get('/order/{id}/deliveries/prepare', [
        'as' => 'Industry.prepareDelivery',
        'uses' => 'IndustryDeliveryController@prepareDelivery',
        'middleware' => 'can:Industry.create_deliveries'
    ]);

    Route::post('/order/{id}/deliveries/add', [
        'as' => 'Industry.addDelivery',
        'uses' => 'IndustryDeliveryController@addDelivery',
        'middleware' => 'can:Industry.create_deliveries'
    ]);

    Route::post('/order/delete', [
        'as' => 'Industry.deleteOrder',
        'uses' => 'IndustryOrderController@deleteOrder',
        'middleware' => 'can:Industry.create_orders'
    ]);


    Route::post('/deliveries/{deliveryId}/state', [
        'as' => 'Industry.setDeliveryState',
        'uses' => 'IndustryDeliveryController@setDeliveryState',
        'middleware' => 'can:Industry.create_deliveries'
    ]);

    Route::post('/deliveries/{deliveryId}/state/{itemId}', [
        'as' => 'Industry.setDeliveryItemState',
        'uses' => 'IndustryDeliveryController@setDeliveryItemState',
        'middleware' => 'can:Industry.create_deliveries'
    ]);

    Route::post('/delivery/{deliveryId}/delete', [
        'as' => 'Industry.deleteDelivery',
        'uses' => 'IndustryDeliveryController@deleteDelivery',
        'middleware' => 'can:Industry.create_deliveries'
    ]);

    Route::post('/delivery/{deliveryId}/delete/{itemId}', [
        'as' => 'Industry.deleteDeliveryItem',
        'uses' => 'IndustryDeliveryController@deleteDeliveryItem',
        'middleware' => 'can:Industry.create_deliveries'
    ]);

    Route::get('/orders/create', [
        'as' => 'Industry.createOrder',
        'uses' => 'IndustryOrderController@createOrder',
        'middleware' => 'can:Industry.create_orders'
    ]);

    Route::post('/orders/{orderId}/update', [
        'as' => 'Industry.updateOrderPrice',
        'uses' => 'IndustryOrderController@updateOrderPrice',
        'middleware' => 'can:Industry.create_orders'
    ]);

    Route::post('/orders/{orderId}/extend', [
        'as' => 'Industry.extendOrderTime',
        'uses' => 'IndustryOrderController@extendOrderTime',
        'middleware' => 'can:Industry.create_orders'
    ]);

    Route::post('/orders/submit', [
        'as' => 'Industry.submitOrder',
        'uses' => 'IndustryOrderController@submitOrder',
        'middleware' => 'can:Industry.create_orders'
    ]);

    Route::post('/user/orders/completed/delete', [
        'as' => 'Industry.deleteCompletedOrders',
        'uses' => 'IndustryOrderController@deleteCompletedOrders',
        'middleware' => 'can:Industry.create_orders'
    ]);

    Route::get('/priceprovider/buildtime')
        ->name('Industry.priceprovider.buildtime.configuration')
        ->uses('IndustryController@buildTimePriceProviderConfiguration')
        ->middleware('can:pricescore.settings');

    Route::post('/priceprovider/buildtime')
        ->name('Industry.priceprovider.buildtime.configuration.post')
        ->uses('IndustryController@buildTimePriceProviderConfigurationPost')
        ->middleware('can:pricescore.settings');
});