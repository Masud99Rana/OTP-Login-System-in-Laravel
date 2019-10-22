<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\Concerns\withExceptionHandling;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class VerifyOTPTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function a_user_can_submit_otp_and_Get_verified()
    {    
    	$this->withExceptionHandling();

    	//create the user
        $user = factory(User::class)->create();
        
        //login the user
        $this->actingAs($user);

        // Cache the otp
        $OTP = auth()->user()->cacheTheOTP();

        $this->post('/verifyOTP', [auth()->user()->OTPKey() => $OTP])->assertStatus(302);
        $this->assertDatabaseHas('users', ['isVerified' => 1]);
    }
}
