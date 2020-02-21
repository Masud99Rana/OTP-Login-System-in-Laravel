<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\Concerns\withoutExceptionHandling;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{   
    use RefreshDatabase;
    
    /** @test */
    public function after_login_user_can_not_access_home_page_until_verified()
    {   
        
        $user = factory(User::class)->create();

        $this->actingAs($user);
        $this->get('/home')->assertRedirect('/verifyOTP');
    }


    /**
    * @test
    */
    public function after_login_user_can_access_home_page_if_verifired()
    {   
        // over write the isVerified factore 0 to 1
        $user = factory(User::class)->create(['isVerified' => 1]);

        $this->actingAs($user);
        $this->get('/home')->assertStatus(200);
    }
}
