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


        DB::table('booking_categories')->insert(
            [
                'slug' => 'cross-posting',
                'named_id' => 'cross-posting',
                'name' => '[cross-posting]',
                'loss_profit_overview' => 0,
                'on_balance' => 1,
                'vat_overview' => 0,
                'polarity' => 1,
            ],
        );

        DB::table('booking_categories')->insert(
            [
                'slug' => 'afschrijving_apparatuur',
                'named_id' => 'afschrijving_apparatuur',
                'name' => 'Afschrijving Apparatuur',
                'loss_profit_overview' => 1,
                'on_balance' => 1,
                'vat_overview' => 1,
                'polarity' => -1,
            ],
        );

        DB::table('booking_categories')->insert(
            [
                'slug' => 'bankkosten',
                'named_id' => 'bankkosten',
                'name' => 'Bankkosten',
                'loss_profit_overview' => 1,
                'on_balance' => 1,
                'vat_overview' => 1,
                'polarity' => -1,
            ],
        );

        DB::table('booking_categories')->insert(
            [
                'slug' => 'belasting',
                'named_id' => 'belasting',
                'name' => 'Belasting',
                'loss_profit_overview' => 0,
                'on_balance' => 0,
                'vat_overview' => 0,
                'polarity' => -1,
            ],
        );

        DB::table('booking_categories')->insert(
            [
                'slug' => 'btw',
                'named_id' => 'btw',
                'name' => 'BTW in 21%',
                'loss_profit_overview' => 0,
                'on_balance' => 1,
                'vat_overview' => 1,
                'polarity' => 1,
            ],
        );

        DB::table('booking_categories')->insert(
            [
                'slug' => 'btw-uit',
                'named_id' => 'btw-uit',
                'name' => 'BTW uit 21%',
                'loss_profit_overview' => 0,
                'on_balance' => 1,
                'vat_overview' => 1,
                'polarity' => -1,
            ],
        );

        DB::table('booking_categories')->insert(
            [
                'slug' => 'computer',
                'named_id' => 'computer',
                'name' => 'Computer',
                'loss_profit_overview' => 1,
                'on_balance' => 1,
                'vat_overview' => 1,
                'polarity' => -1,
            ],
        );

        DB::table('booking_categories')->insert(
            [
                'slug' => 'huisvesting',
                'named_id' => 'huisvesting',
                'name' => 'Huisvesting',
                'loss_profit_overview' => 1,
                'on_balance' => 1,
                'vat_overview' => 1,
                'polarity' => -1,
            ],
        );

        DB::table('booking_categories')->insert(
            [
                'slug' => 'inkomsten',
                'named_id' => 'inkomsten',
                'name' => 'Inkomsten',
                'loss_profit_overview' => 1,
                'on_balance' => 1,
                'vat_overview' => 1,
                'polarity' => 1,
            ],
        );

        DB::table('booking_categories')->insert(
            [
                'slug' => 'prive',
                'named_id' => 'prive',
                'name' => 'Privé',
                'loss_profit_overview' => 0,
                'on_balance' => 0,
                'vat_overview' => 0,
                'polarity' => -1,
            ],
        );

        DB::table('booking_categories')->insert(
            [
                'slug' => 'reiskosten',
                'named_id' => 'reiskosten',
                'name' => 'Reiskosten',
                'loss_profit_overview' => 1,
                'on_balance' => 1,
                'vat_overview' => 1,
                'polarity' => -1,
            ],
        );

        DB::table('booking_categories')->insert(
            [
                'slug' => 'serverkosten',
                'named_id' => 'serverkosten',
                'name' => 'Serverkosten',
                'loss_profit_overview' => 1,
                'on_balance' => 1,
                'vat_overview' => 1,
                'polarity' => -1,
            ],
        );

        DB::table('booking_categories')->insert(
            [
                'slug' => 'telefoon',
                'named_id' => 'telefoon',
                'name' => 'Telefoon',
                'loss_profit_overview' => 1,
                'on_balance' => 1,
                'vat_overview' => 1,
                'polarity' => -1,
            ],
        );

        DB::table('booking_categories')->insert(
            [
                'slug' => 'verzekering',
                'named_id' => 'verzekering',
                'name' => 'Verzekering',
                'loss_profit_overview' => 1,
                'on_balance' => 1,
                'vat_overview' => 1,
                'polarity' => -1,
            ],
        );

        DB::table('booking_categories')->insert(
            [
                'slug' => 'werk-derden',
                'named_id' => 'werk-derden',
                'name' => 'Werk door Derden',
                'loss_profit_overview' => 1,
                'on_balance' => 1,
                'vat_overview' => 1,
                'polarity' => -1,
            ],
        );

        DB::table('booking_categories')->insert(
            [
                'slug' => 'administratie',
                'named_id' => 'administratie',
                'name' => 'Administratie',
                'loss_profit_overview' => 1,
                'on_balance' => 1,
                'vat_overview' => 1,
                'polarity' => -1,
            ],
        );
    }
}
