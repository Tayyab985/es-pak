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
            $table->foreignId('lab_test_id')->references('id')->on('labtests')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('lab_test_parameter_id')->references('id')->on('labtestparameters')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('customer_id')->references('id')->on('customers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('customer_query_id')->references('id')->on('customer_queries')->onDelete('cascade')->onUpdate('cascade');
            $table->text('sample_image_path')->nullable();
            $table->boolean('sample_collected')->nullable();
            $table->foreignId('operator_id')->references('id')->on('operators')->onDelete('cascade')->onUpdate('cascade');
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
