<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Request;

class RouteServiceProviderTest extends TestCase
{

    public function test_routes_are_loaded()
    {
        $routes = collect(app('router')->getRoutes()->getRoutes());

        // Assert that the routes collection is not empty
        $this->assertFalse($routes->isEmpty());

        // Assert that the routes collection contains at least one GET route
        $this->assertTrue($routes->contains(function ($route) {
            return $route->methods()[0] === 'GET';
        }));
    }


    // public function test_configure_rate_limiting()
    // {
    //     $this->assertTrue(method_exists($this->app, 'configureRateLimiting'), 'configureRateLimiting method is not defined in the app');

    //     $request = Request::create('/login');

    //     $this->app->configureRateLimiting();

    //     $this->assertTrue($request->isRateLimited());
    // }


}
