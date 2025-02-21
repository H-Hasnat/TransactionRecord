<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();

            $table->string('cus_number')->nullable();
            $table->string('amount');

            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnUpdate()->cascadeOnDelete();

            $table->unsignedBigInteger('number_details_id');
            $table->foreign('number_details_id')->references('id')->on('number_details')->cascadeOnUpdate()->cascadeOnDelete();

            $table->unsignedBigInteger('payment_details_id')->nullable();
            $table->foreign('payment_details_id')->references('id')->on('payment_methods')->cascadeOnUpdate()->cascadeOnDelete();


            $table->string("name")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
