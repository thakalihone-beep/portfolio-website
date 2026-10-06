<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('college_notes', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();

            $table->string('subject')->nullable();
            $table->string('semester')->nullable();
            $table->string('course')->nullable();

            $table->text('description')->nullable();
            $table->longText('content');

            $table->json('tags')->nullable();
            $table->string('cover_image')->nullable();

            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('college_notes');
    }
};
