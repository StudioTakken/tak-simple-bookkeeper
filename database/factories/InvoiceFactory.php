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


        $items = [];

        // do a loop to create 3 random items
        for ($i = 0; $i < 3; $i++) {

            $items[$i]['item_nr'] = $i;
            $items[$i]['description'] = $faker->text;
            $items[$i]['number'] = $faker->numberBetween(1, 20);
            $items[$i]['rate'] = $faker->numberBetween(6000, 7000);
            $items[$i]['item_amount'] = 0;
        }



        return [
            'invoice_nr' => $faker->unique->numberBetween(100, 1000),
            'client_id' => $client->id,
            'date' => $faker->date,
            'description' => $faker->name,
            'amount' =>  0,
            'vat' =>  21,
            'amount_vat' =>  0,
            'amount_inc' =>  0,
            'details' => json_encode($items)
        ];
    }
}
