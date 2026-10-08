<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $colonnes = ['parent_nom', 'parent_email', 'parent_telephone'];

    public function up(): void
    {
        // N'ajoute que les colonnes qui n'existent pas encore
        Schema::table('eleves', function (Blueprint $table) {
            foreach ($this->colonnes as $colonne) {
                if (!Schema::hasColumn('eleves', $colonne)) {
                    $table->string($colonne)->nullable();
                }
            }
        });
    }

    public function down(): void
    {
        $presentes = array_filter($this->colonnes, fn ($c) => Schema::hasColumn('eleves', $c));

        if ($presentes) {
            Schema::table('eleves', function (Blueprint $table) use ($presentes) {
                $table->dropColumn(array_values($presentes));
            });
        }
    }
};
