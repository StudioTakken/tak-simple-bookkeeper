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
            $table->integer('polarity');
            $table->string('invoice_nr');
            $table->string('bank_code');
            $table->integer('amount');
            $table->string('tag');
            $table->string('mutation_type');
            $table->integer('category')->nullable();
            $table->string('cross_account')->nullable();
            $table->text('remarks');
            $table->json('originals')->nullable();
            $table->string('hashed');

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
