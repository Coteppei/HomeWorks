<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return 'Hello, World!';
// });

Route::get('/','BlogController@showList')->namespace('blogs');