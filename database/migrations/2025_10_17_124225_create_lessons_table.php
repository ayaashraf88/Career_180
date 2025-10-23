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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('module_id')->unsigned()->nullable();
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('SET NULL');
            $table->string('title');
            $table->string('video_url')->nullable();
            $table->string('content')->nullable();
            $table->boolean('   ')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
