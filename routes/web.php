<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\Admin\LoginController::class, 'index'])->name('admin.login');
Route::post('/login', [App\Http\Controllers\Admin\LoginController::class, 'login'])->name('admin.login.post');

Route::group(['middleware' => 'admin', 'prefix' => 'backend-admin', 'namespace' => 'App\Http\Controllers\Admin'], function () {
    Route::post('/logout', 'LoginController@logout')->name('admin.logout');
    Route::get('dashboard', 'HomeController@index')->name('admin.dashboard');

    // User
    Route::get('user', [
        'as' => 'user.index',
        'uses' => 'UserController@index',
        //'middleware' => ['checkPrivilege:user'],
    ]);
    Route::get('user/list', [
        'as' => 'user.list',
        'uses' => 'UserController@result',
        //'middleware' => ['checkPrivilege:user'],
    ]);
    Route::get('user/create-update/{id?}', [
        'as' => 'user.create.update',
        'uses' => 'UserController@createUpdate',
        //'middleware' => ['checkPrivilege:user'],
    ]);
    Route::post('user/create-update', [
        'as' => 'user.create.update.post',
        'uses' => 'UserController@createUpdatePost',
        //'middleware' => ['checkPrivilege:user'],
    ]);
    Route::get('user/action/{id}/{status}', [
        'as' => 'user.action',
        'uses' => 'UserController@action',
        //'middleware' => ['checkPrivilege:user'],
    ]);

    //ViewStructureDontRemoveThisLine
});
