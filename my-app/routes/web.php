<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controller\ControllerUser;
use App\Http\Controllers\CheckoutController;

Route::get('/user', function(Request $request){
    dd($request->except('token'));
});