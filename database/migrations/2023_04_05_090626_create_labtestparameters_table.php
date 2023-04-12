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
        Schema::create('labtestparameters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('method')->nullable();
            $table->string('equipment_used')->nullable();
            $table->string('uncertainity')->nullable();
            $table->foreignId('lab_test_id')->references('id')->on('labtests');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labtestparameters');
    }
};
