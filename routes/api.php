<?php

use Illuminate\Http\Request;

Route::resource('rewards', 'RewardController')->only('index');
