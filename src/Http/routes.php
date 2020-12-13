<?php

use Dcat\Admin\Satan\Env\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('dcat-env', Controllers\DcatEnvController::class.'@index');
