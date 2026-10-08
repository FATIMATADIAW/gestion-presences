<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('eleves', function (Blueprint $table) {
            foreach (['parent_nom', 'parent_email', 'parent_telephone',
                      'pere_nom', 'pere_email', 'mere_nom', 'mere_email'] as $col) {
                if (!Schema::hasColumn('eleves', $col)) {
                    $table->string($col)->nullable();
                }
            }
        });
    }

    public function down(): void
    {
        //
    }
};
