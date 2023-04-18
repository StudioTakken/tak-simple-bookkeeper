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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_nr')->nullable();
            $table->date('date')->nullable();
            $table->string('description');
            $table->integer('amount')->nullable();
            $table->integer('vat')->default(21);
            $table->integer('amount_vat')->nullable();
            $table->integer('amount_inc')->nullable();
            $table->json('details')->nullable();
            $table->string('exported')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
