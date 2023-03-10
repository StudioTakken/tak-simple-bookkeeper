<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('booking_accounts')->insert(
            [
                'slug' => 'debiteuren',
                'key' => 'debiteuren',
                'name' => 'Debiteuren',
                'include_children' => 1,
                'start_balance' => 0,
            ],
        );

        DB::table('booking_accounts')->insert(
            [
                'slug' => 'crediteuren',
                'key' => 'crediteuren',
                'name' => 'Crediteuren',
                'include_children' => 1,
                'start_balance' => 0,
            ],
        );


        DB::table('booking_accounts')->insert(
            [
                'slug' => 'bank',
                'key' => 'NL94INGB0007001049',
                'name' => 'Bank',
                'include_children' => 1,
                'start_balance' => 0,
            ],
        );

        DB::table('booking_accounts')->insert(
            [
                'slug' => 'spaarrekening',
                'key' => 'spaarrekening',
                'name' => 'Spaarrekening',
                'include_children' => 1,
                'start_balance' => 0,
            ],
        );


        DB::table('booking_accounts')->insert(
            [
                'slug' => 'kas',
                'key' => 'kas',
                'name' => 'Kas',
                'include_children' => 1,
                'start_balance' => 0,
            ],
        );


        DB::table('booking_accounts')->insert(
            [
                'slug' => 'apparatuur',
                'key' => 'apparatuur',
                'name' => 'Apparatuur',
                'include_children' => 1,
                'start_balance' => 0,
            ],


        );
    }
}
