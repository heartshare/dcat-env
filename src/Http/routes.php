<?php

use Dcat\Admin\Satan\Env\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::resource('dcat-env',Controllers\DcatEnvController::class);
