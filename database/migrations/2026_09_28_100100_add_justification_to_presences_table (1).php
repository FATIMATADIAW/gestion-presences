<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // N'ajoute que les colonnes qui n'existent pas encore
        Schema::table('presences', function (Blueprint $table) {
            if (!Schema::hasColumn('presences', 'justifie')) {
                $table->boolean('justifie')->default(false);
            }
            if (!Schema::hasColumn('presences', 'motif')) {
                $table->string('motif')->nullable();
            }
            if (!Schema::hasColumn('presences', 'commentaire')) {
                $table->text('commentaire')->nullable();
            }
            if (!Schema::hasColumn('presences', 'justifie_le')) {
                $table->timestamp('justifie_le')->nullable();
            }
            if (!Schema::hasColumn('presences', 'alerte_envoyee_le')) {
                $table->timestamp('alerte_envoyee_le')->nullable();
            }
        });
    }

    public function down(): void
    {
        $colonnes = ['justifie', 'motif', 'commentaire', 'justifie_le', 'alerte_envoyee_le'];
        $presentes = array_filter($colonnes, fn ($c) => Schema::hasColumn('presences', $c));

        if ($presentes) {
            Schema::table('presences', function (Blueprint $table) use ($presentes) {
                $table->dropColumn(array_values($presentes));
            });
        }
    }
};
