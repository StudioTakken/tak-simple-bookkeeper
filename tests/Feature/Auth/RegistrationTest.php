<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


// php artisan test --filter RegistrationTest tests/Feature/Auth/RegistrationTest.php

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_not_be_rendered(): void
    {

        // we dont want a registration screen

        $response = $this->get('/register');
        $response->assertStatus(404);
    }

    // public function test_registration_screen_can_be_rendered(): void
    // {
    //     $response = $this->get('/register');
    //     $response->assertStatus(200);
    // }


    // public function test_new_users_can_register(): void
    // {
    //     $response = $this->post('/register', [
    //         'name' => 'Test User',
    //         'email' => 'test@example.com',
    //         'password' => 'password',
    //         'password_confirmation' => 'password',
    //     ]);

    //     $this->assertAuthenticated();
    //     $response->assertRedirect(RouteServiceProvider::HOME);
    // }
}
