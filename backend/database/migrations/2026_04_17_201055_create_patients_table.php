<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('patients', function (Blueprint $table) {
        $table->ulid('id')->primary();
        
        $table->string('cedula', 20)->unique();
        
        $table->string('first_name', 100);
        $table->string('last_name', 100);
        $table->date('birth_date');
        $table->enum('gender', ['Masculino', 'Femenino', 'Otro']);
        
        $table->string('phone', 30)->nullable();
        $table->string('email', 150)->unique()->nullable();
        $table->text('address')->nullable();
        
        $table->enum('blood_type', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable();
        $table->text('allergies')->nullable();
        $table->text('chronic_conditions')->nullable();
        
        $table->foreignId('user_id')->constrained();
        
        $table->timestamps(); 
        $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
