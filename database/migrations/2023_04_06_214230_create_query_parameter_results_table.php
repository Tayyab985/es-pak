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
        Schema::create('query_parameter_results', function (Blueprint $table) {
            $table->id();
            $table->string('concentration')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('lab_test_id')->references('id')->on('labtests');
            $table->foreignId('lab_test_parameter_id')->references('id')->on('labtestparameters');
            $table->foreignId('customer_id')->references('id')->on('customers');
            $table->foreignId('customer_query_id')->references('id')->on('customer_queries');
            $table->text('sample_image_path')->nullable();
            $table->boolean('sample_collected')->nullable();
            $table->foreignId('operator_id')->nullable()->references('id')->on('operators');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('query_parameter_results');
    }
};
