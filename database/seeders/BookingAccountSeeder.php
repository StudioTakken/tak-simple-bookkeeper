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


        $main_booking_account = config('bookings.main_booking_account');


        DB::table('booking_accounts')->insert(
            [
                'slug' => 'debiteuren',
                'named_id' => 'debiteuren',
                'name' => 'Debiteuren',
                'include_children' => 1,
                'intern' => 1,
                'polarity' => 1,
                'start_balance' => 0,
            ],
        );

        DB::table('booking_accounts')->insert(
            [
                'slug' => 'crediteuren',
                'named_id' => 'crediteuren',
                'name' => 'Crediteuren',
                'include_children' => 1,
                'intern' => 1,
                'polarity' => -1,
                'start_balance' => 0,
            ],
        );


        DB::table('booking_accounts')->insert(
            [
                'slug' => 'bank',
                'named_id' =>  $main_booking_account,
                'name' =>  $main_booking_account,
                'include_children' => 1,
                'intern' => 1,
                'polarity' => 1,
                'start_balance' => 0,
            ],
        );

        DB::table('booking_accounts')->insert(
            [
                'slug' => 'spaarrekening',
                'named_id' => 'spaarrekening',
                'name' => 'Spaarrekening',
                'include_children' => 1,
                'intern' => 1,
                'polarity' => 1,
                'start_balance' => 0,
            ],
        );


        DB::table('booking_accounts')->insert(
            [
                'slug' => 'kas',
                'named_id' => 'kas',
                'name' => 'Kas',
                'include_children' => 1,
                'intern' => 1,
                'polarity' => 1,
                'start_balance' => 0,
            ],
        );


        DB::table('booking_accounts')->insert(
            [
                'slug' => 'apparatuur',
                'named_id' => 'apparatuur',
                'name' => 'Apparatuur',
                'include_children' => 1,
                'intern' => 1,
                'polarity' => 1,
                'start_balance' => 0,
            ],


        );
    }
}
