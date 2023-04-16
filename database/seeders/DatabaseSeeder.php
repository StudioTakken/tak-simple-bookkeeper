<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Client;
use Database\Factories\ClientFactory;
use Illuminate\Database\Seeder;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            BookingAccountSeeder::class,
            BookingCategorySeeder::class,
        ]);

        Client::factory()->count(10)->create();
    }

    // protected function configureFactories()
    // {
    //     $this->app->bind(ClientFactory::class, function () {
    //         return ClientFactory::new();
    //     });

    //     $this->app->resolving(ClientFactory::class, function ($factory, $app) {
    //         $factory->setConnection($this->getConnection());
    //     });
    // }
}
