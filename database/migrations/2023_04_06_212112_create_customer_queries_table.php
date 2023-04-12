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
        Schema::create('customer_queries', function (Blueprint $table) {
            $table->id();
            $table->text('current_state')->nullable();
            $table->foreignId('customer_id')->references('id')->on('customers');
            $table->text('lab_test_ids')->nullable();
            $table->text('operators_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_queries');
    }
};
