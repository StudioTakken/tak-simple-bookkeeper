<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;


    public function definition()
    {

        $faker = \Faker\Factory::create('nl_NL');

        return [
            'company_name' => $faker->company,
            'tav' => $faker->name,
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
            'address' => $faker->streetAddress,
            'zip_code' => $faker->postcode(null, '####@@'),
            'city' => $faker->city,
        ];
    }
}
