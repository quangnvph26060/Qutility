<?php

use Illuminate\Support\Facades\Route;
use Wuang\Qutility\Controller\QutilityController;
use Wuang\Qutility\Wuang;

Route::middleware(Wuang::gtc())->controller(QutilityController::class)->group(function(){
    Route::get('activate','WuangStart')->name('activate');
    Route::post('activate_system_submit','laraminSubmit')->name('activate_system_submit');
});