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
        Schema::create('lab_test_paramter_limits', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('min_value')->nullable();
            $table->bigInteger('max_value')->nullable();
            $table->string('limit_type_enum')->nullable();
            $table->foreignId('lab_test_parameter_id')->references('id')->on('labtestparameters');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_test_paramter_limits');
    }
};
