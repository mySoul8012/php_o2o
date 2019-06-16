<?php
use think\facade\Route;

Route::get('/[:config]', "\\think\\captcha\\CaptchaController@index");