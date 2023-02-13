<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // set date	Rekening	Tegenrekening	Omschrijving	plusMin	invoice_nr	category	Bedrag	Btw	Bedrag_inc	Mededelingen	Tag	Mutatiesoort
            $table->date('date');
            $table->string('account');
            $table->string('contra_account');
            $table->string('description');
            $table->string('plus_min');
            $table->integer('plus_min_int');
            $table->string('invoice_nr');
            $table->string('category');
            $table->decimal('amount', 10, 2);
            $table->decimal('btw', 10, 2);
            $table->decimal('amount_inc', 10, 2);

            $table->string('remarks');
            $table->string('tag');
            $table->string('mutation_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
