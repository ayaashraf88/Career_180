<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('lessons', 'visible')) {
            Schema::table('lessons', function (Blueprint $table) {
                $table->boolean('visible')->default(true)->after('content');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('lessons', 'visible')) {
            Schema::table('lessons', function (Blueprint $table) {
                $table->dropColumn('visible');
            });
        }
    }
};
