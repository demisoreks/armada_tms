<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$link_id = DB::table('amd_config')->whereId(1)->first()->link_id;

Route::get('/', [
    'as' => 'welcome', 'uses' => 'WelcomeController@index'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin,Detailer,Commander,Supervisor']);

Route::get('regions/{region}/disable', [
    'as' => 'regions.disable', 'uses' => 'RegionsController@disable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::get('regions/{region}/enable', [
    'as' => 'regions.enable', 'uses' => 'RegionsController@enable'
])->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::resource('regions', 'RegionsController')->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::bind('regions', function($value, $route) {
    return App\AmdRegion::findBySlug($value)->first();
});

Route::resource('users', 'UsersController')->middleware(['auth.user', 'auth.access:'.$link_id.',Admin']);
Route::bind('users', function($value, $route) {
    return App\AmdUser::findBySlug($value)->first();
});