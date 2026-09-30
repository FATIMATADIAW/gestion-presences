<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('eleves', function (Blueprint $table) {
            $table->string('pere_nom')->nullable();
            $table->string('pere_email')->nullable();
            $table->string('mere_nom')->nullable();
            $table->string('mere_email')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('eleves', function (Blueprint $table) {
            $table->dropColumn(['pere_nom', 'pere_email', 'mere_nom', 'mere_email']);
        });
    }
};