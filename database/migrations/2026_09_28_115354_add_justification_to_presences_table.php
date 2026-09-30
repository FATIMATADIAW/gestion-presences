<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('presences', function (Blueprint $table) {
            $table->boolean('justifiee')->default(false);
            $table->string('motif')->nullable();
            $table->text('commentaire')->nullable();
            $table->timestamp('justifiee_le')->nullable();
            $table->timestamp('alerte_envoyee_le')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('presences', function (Blueprint $table) {
            $table->dropColumn(['justifiee', 'motif', 'commentaire', 'justifiee_le', 'alerte_envoyee_le']);
        });
    }
};