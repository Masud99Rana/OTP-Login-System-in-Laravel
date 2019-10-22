<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerifyOTPController extends Controller
{
    public function verify(Request $request)
    {
            auth()->user()->update(['isVerified' => true]);
            return redirect('/home');

    }

}
