<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('subject_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title');
            $table->string('slug')->unique();

            $table->string('topic')->nullable();

            $table->longText('content')->nullable();

            $table->string('thumbnail')->nullable();

            $table->string('note_type')->default('text');

            $table->unsignedInteger('sort_order')->default(0);

            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);

            $table->timestamp('published_at')->nullable();

            $table->timestamps();

            $table->index('note_type');
            $table->index('is_featured');
            $table->index('is_published');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
