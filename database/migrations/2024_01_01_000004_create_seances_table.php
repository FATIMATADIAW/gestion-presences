<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seances', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('heure');
            $table->string('matiere', 50);
            $table->foreignId('classe_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('enseignant_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seances');
    }
};
