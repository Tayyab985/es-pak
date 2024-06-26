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
        Schema::create('operators', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('password')->nullable();
            $table->enum('role', ['admin', 'field_officer', 'lab_sample_receiver', 'chemist', 'supervisor']);
            $table->boolean('admin')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operators');
    }
};
