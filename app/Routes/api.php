<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'middleware' => 'api_token'], function () {
    Route::get('post', 'Api\PostController@index');
    Route::post('post', 'Api\PostController@store')->middleware('user_can_manage_post');
});
