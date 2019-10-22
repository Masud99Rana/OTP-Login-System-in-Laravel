<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerifyOTPController extends Controller
{
    public function verify(Request $request)
    {
        if (request('OTP') == auth()->user()->OTP()) {
            auth()->user()->update(['isVerified' => true]);
            return redirect('/home');
        }

        return back()->withErrors('OTP is expired or invalid');
    }

    public function showVerifyForm()
    {
        return view('OTP.verify');
    }
}
