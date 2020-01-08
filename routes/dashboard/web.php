<?php

Route::group([ 'prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ] ], function()
{
    /** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
    Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function(){

        Route::get('/', 'WelcomeController@index')->name('welcome');

        // Categories Routes
        Route::resource('categories', 'CategoryController')->except(['show']);

        // Products Routes
        Route::resource('products', 'ProductController')->except(['show']);

        // Clients Routes
        Route::resource('clients', 'ClientController')->except(['show']);
        // Clients Orders Routes
        Route::resource('clients.orders', 'Client\OrderController')->except(['show']);
        
        // Orders Routes
        Route::resource('orders', 'OrderController')->except(['show']);
        Route::get('orders.products', 'OrderController@products');


        // Users Routes
        Route::resource('users', 'UserController')->except(['show']);

    });

});
