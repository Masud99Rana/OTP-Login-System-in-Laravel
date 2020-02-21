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

        $this->post('/verifyOTP', ['OTP' => $OTP])->assertStatus(302);

        $this->assertDatabaseHas('users', ['isVerified' => 1]);
    }

    /**
    * @test
    */
    public function user_can_see_otp_verify_page()
    {	
    	$this->withExceptionHandling();

        $this->get('/verifyOTP')
        ->assertStatus(200) // we can write in controller return resposnse(null, 200); just idea
        ->assertSee('Enter OTP');
    }

    /**
    * @test
    */
    public function invalid_otp_returns_error_message()
    {   
        //create the user
        $user = factory(User::class)->create();       
        //login the user
        $this->actingAs($user);

        $this->post('/verifyOTP', ['OTP' => 'InvalidOTP'])->assertSessionHasErrors();
    }

    /**
    * @test
    */
    public function if_no_otp_is_given_then_it_return_with_error()
    {
        $this->withExceptionHandling();
        
        //create the user
        $user = factory(User::class)->create();       
        //login the user
        $this->actingAs($user);

        $this->post('/verifyOTP', ['OTP' => null])->assertSessionHasErrors(['OTP']);
    }
}
