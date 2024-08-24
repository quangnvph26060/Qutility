<?php

use Illuminate\Support\Facades\Route;
use Wuang\Qutility\Controller\QutilityController;
use Wuang\Qutility\Wuang;

// Route::middleware(VugiChugi::gtc())->controller(QutilityController::class)->group(function(){
//     Route::get(VugiChugi::acRouter(),'laraminStart')->name(VugiChugi::acRouter());
//     Route::post(VugiChugi::acRouterSbm(),'laraminSubmit')->name(VugiChugi::acRouterSbm());
// });
Route::middleware(Wuang::gtc())->controller(QutilityController::class)->group(function(){
    Route::get('active','WuangStart')->name('active');
    Route::post('active_system_submit','laraminSubmit')->name('active_system_submit');
});