<?php

namespace Tests\Feature;

use App\Mail\OTPMail;
use App\User;
use Illuminate\Foundation\Testing\Concerns\withoutExceptionHandling;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
class EmailTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function an_otp_email_is_send_when_user_is_logged_in()
    {   
        Mail::fake();

        $user = factory(User::class)->create();

        $res = $this->post('/login', ['email' => $user->email, 'password' => 'password']);

        Mail::assertSent(OTPMail::class);

    }


    /**
    * @test
    */
    public function an_otp_email_is_not_send_if_credentials_are_incorrect()
    {   
        // $this->withoutExceptionHandling();
        Mail::fake();

        $user = factory(User::class)->create();

        $res = $this->post('/login', ['email' => $user->email, 'password' => 'password1234']);

        Mail::assertNotSent(OTPMail::class);
    }

    /**
    * @test
    */
    public function otp_is_stored_in_cache_for_the_user()
    {
        $user = factory(User::class)->create();
        $res = $this->post('/login', ['email' => $user->email, 'password' => 'password']);

        $this->assertNotNull($user->OTP());// here OTP() is the function in user table
    }
}
