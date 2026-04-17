<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

        public function up(): void
        {
            Schema::create('surgeries', function (Blueprint $table) {
                $table->id();
                
                $table->foreignUlid('patient_id')->constrained()->onDelete('cascade');
                $table->foreignId('surgery_type_id')->constrained()->onDelete('restrict'); 
                $table->foreignId('user_id')->constrained();

                $table->dateTime('scheduled_date');
                $table->dateTime('execution_date')->nullable();
                $table->enum('status', ['Pendiente', 'Realizada', 'Atrasada', 'Cancelada'])->default('Pendiente');
                
                $table->text('observations')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }

    public function down(): void
    {
        Schema::dropIfExists('surgeries');
    }
};
