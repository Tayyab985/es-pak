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
        Schema::create('operatorsWorked', function (Blueprint $table) {
            $table->id();
            $table->foreignId('operator_id')->references('id')->on('operators');
            $table->integer('role')->nullable();
            $table->foreignId('customer_query_id')->references('id')->on('customer_queries');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operatorsWorked');
    }
};
