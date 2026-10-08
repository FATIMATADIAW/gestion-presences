
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('presences', function (Blueprint $table) {
            if (!Schema::hasColumn('presences', 'justifiee')) {
                $table->boolean('justifiee')->default(false);
            }
            if (!Schema::hasColumn('presences', 'motif')) {
                $table->string('motif')->nullable();
            }
            if (!Schema::hasColumn('presences', 'commentaire')) {
                $table->text('commentaire')->nullable();
            }
            if (!Schema::hasColumn('presences', 'justifiee_le')) {
                $table->timestamp('justifiee_le')->nullable();
            }
            if (!Schema::hasColumn('presences', 'alerte_envoyee_le')) {
                $table->timestamp('alerte_envoyee_le')->nullable();
            }
        });
    }

    public function down(): void
    {
        //
    }
};
