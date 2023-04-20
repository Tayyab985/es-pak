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
        Schema::create('query_tests', function (Blueprint $table) {
            $table->id();
            $table->text('lab_test_parameter_ids')->nullable();
            $table->foreignId('lab_test_id')->references('id')->on('labtests');
            $table->foreignId('customer_query_id')->references('id')->on('customer_queries');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('query_tests');
    }
};
