<?php

use App\Mail\OTPMail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
                $OTP = rand(100000, 999999);

            Cache::put(['OTP' => $OTP], now()->addSeconds(20));

           // $mail = Mail::to('masudrana@test.com')->send(new OTPMail($OTP));
           // 
           Mail::to('MasudRana@gmail.com')->send(new OTPMail($OTP));

            return "Hello";
});

Auth::routes();

// Route::get('/verifyOTP', 'VerifyOTPController@showVerifyForm');
Route::post('/verifyOTP', 'VerifyOTPController@verify');
// Route::post('/resend_otp', 'ResendOTPController@resend');

Route::group(['middleware' => 'TwoFA'], function () {
	Route::get('/home', 'HomeController@index')->name('home');
});
