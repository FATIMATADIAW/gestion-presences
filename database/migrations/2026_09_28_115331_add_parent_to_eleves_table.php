<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('eleves', function (Blueprint $table) {
            $table->string('parent_nom')->nullable();
            $table->string('parent_email')->nullable();
            $table->string('parent_telephone')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('eleves', function (Blueprint $table) {
            $table->dropColumn(['parent_nom', 'parent_email', 'parent_telephone']);
        });
    }
};