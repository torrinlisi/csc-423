<?php

Route::get('/',function(){
    return view('index');
});

Route::get('/vendor/', 'VendorsController@index');

Route::get('/vendor/view/{id}', ['uses' => 'VendorsController@viewVendor', 'as' => 'viewVendor']);

Route::get('/vendor/addVendor',function(){
    return view('Vendor.addVendor');
});

Route::get('/vendor/deleteVendor/{id}', ['uses' => 'VendorsController@deleteVendor', 'as' => 'deleteVendor']);

Route::post('/vendor/addVendor', array('as' => 'insert', 'uses' => 'VendorsController@insertNewVendor'));

Route::get('/vendor/editVendor/{id}', ['uses' => 'VendorsController@editVendor', 'as' => 'editVendor']);

Route::post('/vendor/updateVendor', array('as' => 'update', 'uses' => 'VendorsController@updateVendor'));

Route::get('/item/', 'InventoryItemsController@index');

Route::get('/item/index', 'InventoryItemsController@index');

Route::get('/item/addItem', 'InventoryItemsController@getVendors');

Route::post('/item/addItem', array('as' => 'insert', 'uses' => 'InventoryItemsController@insertNewItem'));

Route::get('/item/editItem/{id}', 'InventoryItemsController@editItem');

Route::post('/item/updateItem', array('as' => 'update', 'uses' => 'InventoryItemsController@updateItem'));

Route::get('/item/deleteItem/{id}', ['uses' => 'InventoryItemsController@deleteItem', 'as' => 'deleteItem']);

Route::get('/item/viewItem/{id}', ['uses' => 'InventoryItemsController@viewItem', 'as' => 'viewItem']);

Route::get('/storeLocations/view/{id}', ['uses' => 'StoresController@viewLocation', 'as' => 'viewLocation']);

Route::get('/storeLocations/', 'StoresController@storeIndex');

Route::get('/storeLocations/addLocation', function(){
    return view('StoreLocation.addLocation');
});

Route::post('/storeLocation/addLocation', array('uses' => 'StoresController@insertNewLocation', 'as' => 'addLocation'));

Route::get('/storeLocations/editLocation/{id}', 'StoresController@editLocation');

Route::post('/storeLocation/updateLocation', array('uses' => 'StoresController@updateLocation', 'as' => 'updateLocation'));

Route::get('/storeLocations/deleteLocation/{id}', ['uses' => 'StoresController@deleteLocation', 'as' => 'deleteLocation']);