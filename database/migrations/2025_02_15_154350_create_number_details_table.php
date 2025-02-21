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
        Schema::create('number_details', function (Blueprint $table) {
            $table->id();
            $table->string("agent_number");
            $table->unsignedBigInteger('account_type_id');
            $table->foreign('account_type_id')->references('id')->on('account_types')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string("amount");
            $table->string("name")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('number_details');
    }
};
