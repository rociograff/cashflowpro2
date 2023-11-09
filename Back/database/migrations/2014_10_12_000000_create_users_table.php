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
        Schema::create('users', function (Blueprint $table) {
            // $table->id();
            // $table->string('nombre');
            // $table->string('apellido');
            // $table->string('usuario')->unique();
            // $table->string('email');
            // $table->string('password');
            // $table->string('color');
            // $table->rememberToken();
            // $table->timestamps();

            $table->id();
            $table->string('nombre');
            $table->string('apellido')->nullable();
            $table->string('usuario')->nullable();
            $table->string('email')->nullable();
            $table->string('paises')->nullable();
            $table->string('password')->nullable(); // Changed to nullable()
            $table->string('google_id')->nullable(); // Added
            $table->string('color')->nullable();
            $table->integer('sesion_iniciada');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
