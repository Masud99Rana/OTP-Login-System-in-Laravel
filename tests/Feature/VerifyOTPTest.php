<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Illuminate\Support\Facades\Cache;

class VerifyOTPTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function a_user_can_submit_otp_and_Get_verified()
    {   

        $otp = rand(100000, 999999);
        Cache::put(['OTP' =>$otp],now()->addSeconds(20));

        $user = factory(User::class)->create();
        $this->actingAs($user);
        
        $this->post('/verifyOTP', ['OTP' => $otp])->assertStatus(302);
        $this->assertDatabaseHas('users', ['isVerified' => 1]);
    }
}
