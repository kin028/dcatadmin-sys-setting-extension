<?php

use Kin\Setting\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('setting', Controllers\SettingController::class.'@index');
Route::post("setting/save", [Controllers\SettingController::class, "save"]);
