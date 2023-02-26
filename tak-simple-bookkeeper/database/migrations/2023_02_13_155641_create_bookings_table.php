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
            $table->integer('parent_id')->nullable();
            $table->date('date');
            $table->string('account');
            $table->string('contra_account');
            $table->string('description');
            $table->string('plus_min');
            $table->integer('plus_min_int');
            $table->string('invoice_nr');
            $table->string('bank_code');
            // $table->integer('amount');
            // $table->integer('btw');
            $table->integer('amount_inc');
            $table->text('remarks');
            $table->string('tag');
            $table->string('mutation_type');
            $table->text('category')->nullable();
            $table->json('originals')->nullable();

            $table->timestamps();
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
