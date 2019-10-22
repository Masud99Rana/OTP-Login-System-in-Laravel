<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerifyOTPController extends Controller
{
    public function verify(Request $request)
    {   
        $this->validate($request,[
            'OTP'=> 'required'
        ]);

        if (request('OTP') == auth()->user()->OTP()) {
            auth()->user()->update(['isVerified' => true]);
            return redirect('/home');
        }

        return back()->withErrors('OTP is expired or invalid');
    }
    

    public function showVerifyForm(){

        return view('OTP.verify');
        // return response(null, 200); if want custom request
    }

}
