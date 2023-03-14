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
                    'plus_min_int' => 1,
                ],
            );
        }
    }
}
