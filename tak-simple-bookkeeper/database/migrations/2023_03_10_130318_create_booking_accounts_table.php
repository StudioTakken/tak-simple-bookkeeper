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
        Schema::create('booking_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('named_id');
            $table->string('name');
            $table->integer('intern');
            $table->integer('plus_min_int');
            $table->string('include_children')->nullable();
            $table->integer('start_balance')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('booking_accounts');
    }
};
