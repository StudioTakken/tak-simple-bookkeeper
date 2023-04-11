<?php

use Illuminate\Http\Request;
use Tests\TestCase;

// php artisan test --filter ExampleTest tests/Feature/ExampleTest.php

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');
        // $response->assertStatus(200);
        // assert that it redirects to login
        $response->assertRedirect('/login');
    }
}
