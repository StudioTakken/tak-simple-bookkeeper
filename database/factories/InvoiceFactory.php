<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {


        $faker = \Faker\Factory::create('nl_NL');

        //  get a random client 
        $client = \App\Models\Client::inRandomOrder()->first();


        $details = [];

        // do a loop to create 3 random items
        for ($i = 0; $i < 3; $i++) {
            $details[$i]['item'] = $faker->text;
            $details[$i]['rate'] = $faker->numberBetween(60, 70);
            $details[$i]['amount'] = $faker->numberBetween(100, 100000);
        }



        return [
            'invoice_nr' => $faker->unique->numberBetween(100, 1000),
            'client_id' => $client->id,
            'date' => $faker->date,
            'description' => $faker->name,
            'amount' =>  $faker->numberBetween(100, 100000),
            'details' => json_encode($details),
        ];
    }
}
