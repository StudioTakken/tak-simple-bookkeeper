<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $categoryList = config('bookings.categories');

        foreach ($categoryList as $slug => $name) {
            DB::table('booking_categories')->insert(
                [
                    'slug' => $slug,
                    'named_id' => $slug,
                    'name' => $name,
                    'loss_and_provit' => 1,
                    'vat_overview' => 1,
                    'polarity' => 1,
                ],
            );
        }
    }
}
